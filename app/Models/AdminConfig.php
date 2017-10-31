<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AdminConfig extends Model
{
    protected $table = 'admin_config';

    const WEBNAME_ID = 1; //('店铺名称');
    const OPENTIMES_ID = 2; //('开店时间');
    const SENDTIMES_ID = 3; //('配送时间');
    const ADDRESS_ID = 4; //('商家地址');
    const SHOPTEL_ID = 5; //('商家电话');
    const SENDMESS_ID = 6; //('配送信息');
    const ACTIVITY_ID = 7; //('活动信息');
    const SERVICE_ID = 8; //('商家服务');
    const STANDARD_ID = 9; //('起送标准');
    const PICTURES_LOGO_ID = 10; //('商家图片');
    const PICTURES1_IDS = 11; //('商家图片');
    const PICTURES2_IDS = 12; //('商家图片');
    const PICTURES3_IDS = 13; //('商家图片');
    const POINTS_ID = 14; //('商品抵扣比例');

    public static function points()
    {
        $point = \App\Models\AdminConfig::where('id', self::POINTS_ID)->value('value');
        $points = explode(':', $point);
        return $point = $points[0] / $points[1];
    }
}
