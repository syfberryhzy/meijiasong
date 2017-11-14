<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AdminConfig;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;
use Carbon\Carbon;

class ConfigPolicy
{
    use HandlesAuthorization;
    /**
     * 匹配配送距离和价格
     * @param  Address $address [description]
     * @return [type]           [description]
     */
    public function defaultAddress(Address $address)
    {
        $distance = $this->getDistance($address['longitude'], $address['latitude']);
        $sendfee = $this->shopSendFee($distance);
        $address['distance'] = $distance;
        $address['sendfee'] = $sendfee;

        return $address;
    }
    //商家信息详情
    public function shopInfo()
    {
        $configs = collect(AdminConfig::all()->toArray())->pluck('value');
        $pictures =  [
            config('app.url') . '/uploads/' . $configs[AdminConfig::PICTURES1_IDS - 1],
            config('app.url') . '/uploads/' . $configs[AdminConfig::PICTURES2_IDS - 1],
            config('app.url') . '/uploads/' . $configs[AdminConfig::PICTURES3_IDS - 1],
        ];
        $data = [
            'shopname' =>  $configs[AdminConfig::WEBNAME_ID - 1],
            'opentimes' => $configs[AdminConfig::OPENTIMES_ID - 1],
            'sendtimes' => $configs[AdminConfig::SENDTIMES_ID - 1],
            'address'  => $configs[AdminConfig::ADDRESS_ID - 1],
            'tel'  => $configs[AdminConfig::SHOPTEL_ID - 1],
            'sendmess' => $configs[AdminConfig::SENDMESS_ID - 1],
            'standard' =>  $configs[AdminConfig::STANDARD_ID - 1],
            'activity' => $configs[AdminConfig::ACTIVITY_ID - 1],
            'service' => $configs[AdminConfig::SERVICE_ID - 1],
            'standard' => $configs[AdminConfig::STANDARD_ID - 1],
            'logo' => config('app.url') . '/uploads/' . $configs[AdminConfig::PICTURES_LOGO_ID - 1],
            'pictures' => $pictures
        ];
        return $data;
    }
    /**
     * 商家地址
     * @return [type] [description]
     */
    public function shopLocation()
    {
        $configAddr = AdminConfig::where('id', AdminConfig::ADDRESS_ID)->first();
        $location = str_replace(array('[', ']'), '', $configAddr->description);

        return explode(',', $location);
    }

    /**
     * 商家配送标准
     * @return [type] [description]
     */
    public function shopSendFee($distance = 0)
    {
        $data = AdminConfig::where('id', AdminConfig::STANDARD_ID)->first();
        $datas = explode("\n", $data->value);

        $sendDatas = array_map(function ($item) {
            return explode('-', str_replace(':', '-', trim($item)));
        }, $datas);
        // dd($sendDatas);
        $sendfee = 0;
        foreach ($sendDatas as $key => $vo) {
            if ($key+1 == count($sendDatas) && $sendfee == 0) {
                $sendfee = $vo[2];
            }
            if ($vo[0] <= $distance && $vo[1] > $distance) {
                $sendfee = $vo[2];
            }
        }
        return $sendfee;
    }
    /**
   * 计算两点地理坐标之间的距离
   * @param  Decimal $longitude1 起点经度
   * @param  Decimal $latitude1  起点纬度
   * @param  Decimal $longitude2 终点经度
   * @param  Decimal $latitude2  终点纬度
   * @param  Int     $unit       单位 1:米 2:公里
   * @param  Int     $decimal    精度 保留小数位数
   * @return Decimal
   */
    public function getDistance($longitude1, $latitude1, $unit = 2, $decimal = 2)
    {
        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = 3.1415926;
        $locations = $this->shopLocation();

        $longitude2 = $locations[0];
        $latitude2 = $locations[1];

        $radLat1 = $latitude1 * $PI / 180.0;
        $radLat2 = $latitude2 * $PI / 180.0;

        $radLng1 = $longitude1 * $PI / 180.0;
        $radLng2 = $longitude2 * $PI /180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a/2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2), 2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        if ($unit==2) {
            $distance = $distance / 1000;
        }

        return round($distance, $decimal);
    }
    // 抵扣积分比例
    public function getPoints()
    {
        $data = AdminConfig::where('id', AdminConfig::POINTS_ID)->first();
        $points = explode(':', $data->value);
        return $points;
    }

    public function getIntegral(User $user, $products)
    {
        #商品抵扣比例
        $points = $this->getPoints();
        $inte = $points[0];
        $money = $points[1];
        #获取可兑换商品的总个数
        $datas = array_map(function ($val) {
            $count = $val['is_default'] == 1 ? $val['number'] : 0;
            $price = $val['price'] * $val['number'];
            return ['count' => $count, 'total_price' => $price];
        }, $products);
        $counts = collect($datas)->sum('count');
        #商品总价
        $total_price = collect($datas)->sum('total_price');


        #统计用户可兑换商品的最大值
        $myInte = $user->integral;
        $number = $myInte % $points[0];
        $counts = $counts <= $number ? $counts : $number;
        if ($myInte == 0 || $counts == 0) {
            $intes = 0;
            $moneys = 0;
            $isShow = 0;
        }
        $isShow= 1;
        $intes = number_format($number * $points[0], 0);
        $moneys = number_format($number * $points[1], 0);
        return ['inte' => $intes, 'money' => $moneys, 'myinte' =>number_format($myInte, 0), 'total' => $total_price, 'amount' => $total_price - $moneys, 'is_show'=> $isShow];
    }

    public function configSend()
    {
        $data = AdminConfig::where('id', AdminConfig::SENDTIMES_ID)->first();
        $sendtimes = explode("-", trim($data->value));
        $sendminutes = $data->description ? $data->description : 0;
        return  [$sendtimes, $sendminutes];
    }

    public function defaultSend()
    {
        #默认配送时间
        $data = $this->configSend();
        $sendtimes = $data[0];
        $sendminutes = $data[1];
        // $now = "10:00";
        // $ordertime = Carbon::parse($now)->addMinutes($sendminutes);
        $ordertime = Carbon::now('Asia/Shanghai')->addMinutes($sendminutes);

        // dd($sendtimes[0]);
        #截止时间的前半个小时
        $end = Carbon::parse($sendtimes[1])->subMinutes(30);
        $isToday = $ordertime->lte($end);
        // dd($isToday);
        if (!$isToday) {
            $ordertime = Carbon::parse($sendtimes[0])->addDay();
        }
        $weeks = $this->getWeeks($sendtimes, $isToday);
        $times = $this->getTimes($ordertime);
        return ['weeks' => $weeks, 'times' => $times, 'time' => substr($ordertime->toTimeString(), 0, 5), 'istoday' => $isToday];
    }

    #配送日期集合
    public function getWeeks($sendtimes, $isToday)
    {
        $start = $isToday ? 0 : 1;
        for ($i = 0 + $start; $i< 7 + $start; $i++) {
            $weeks[] = substr(Carbon::now('Asia/Shanghai')->addDays($i)->toDateString(), 5, 5);
        }
        return $weeks;
    }

    // 配送时间段
    public function getTimes($defaultTime = '')
    {
        $data = $this->configSend();
        $sendtimes = $data[0];


        $defaultTime = $defaultTime ? $defaultTime : Carbon::now('Asia/Shanghai');
        $isToday = Carbon::parse($defaultTime)->isToday();

        $start = Carbon::parse($sendtimes[0]);
        $end = Carbon::parse($sendtimes[1]);

        #开始和截止时间的时间差
        $diffMinutes = $start->diffInMinutes($end);
        $number = $diffMinutes / 30;
        $residue = $diffMinutes % 30;

        $number = $residue == 0 ? $number : $number + 1;
        for ($i = 0; $i <= $number; $i++) {
            if ($i == $number && $residue != 0) {
                $time = $end->toTimeString();
            } else {
                $time = Carbon::parse($sendtimes[0])->addMinutes(30 * $i);
            }
            $timeDatas[] = substr($time->toTimeString(), 0, 5);
            if (($time->gte($defaultTime) && $isToday) || !$isToday) {
                $times[] = substr($time->toTimeString(), 0, 5);
            }
        }
        $datas = $this->toDatas($times);
        $timeDatas = $this->toDatas($timeDatas);
        return [$datas, $timeDatas];
    }

    public function toDatas($times)
    {
        $datas = [];
        foreach ($times as $key => $val) {
            if ($key < count($times) - 1) {
                $datas[] = $val. ' - ' . $times[$key+1];
            }
        }
        return $datas;
    }
}
