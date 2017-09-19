<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Shelf;

class UserExporter extends AbstractExporter
{
    public function export()
    {
        $table = $this->getTable();
        $data = $this->getData();

        $tableDatas = self::getDatas($table, $data);

        $filename = '美家送'. $tableDatas[1] .'.csv';

        $output = $tableDatas[0];

        $headers = [
            'Content-Encoding'    => 'UTF-8',
            'Content-Type'        => 'text/csv;charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        response(rtrim($output, "\n"), 200, $headers)->send();
        exit;
    }

    public function getDatas($table, $data)
    {
        $datas = [
          'users' =>[
                'columnsname' => ["编号ID", "用户名", '性别', "微信标识", "积分", "余额（元）", "创建时间"],
                'rowtitles' =>  ['id', 'name', 'gender', 'openid', 'integral', 'balance', 'created_at'],
                'filename' =>  '用户记录',
          ],
          'products' =>[
                'columnsname' => ["编号ID", "商品名称", '属性', "单价（元）", "抵扣比例", "销量", "状态"],
                'rowtitles' =>  ['id', 'shelf_id', 'characters', 'price', 'points', 'sales', 'status'],
                'filename' =>  '商品记录',
          ],
          'orders' =>[
                'columnsname' => ["编号ID", "用户名", '性别', "微信标识", "积分", "余额（元）", "创建时间"],
                'rowtitles' =>  ['id', 'name', 'gender', 'openid', 'integral', 'balance', 'created_at'],
                'filename' =>  '订单记录',
          ]
        ];

        $titles = $datas[$table]['columnsname'];
        $rowtitles = $datas[$table]['rowtitles'];
        $filename = $datas[$table]['filename'];

        $output = self::putcsv($titles);
        foreach ($data as $row) {
          // dd($row);
            $row = self::getRow($table, $row);
            $row = array_only($row, $rowtitles);
            #排序

            $val = [];
            foreach ($rowtitles as $key => $vo) {
                $val[] = $row[$vo];
            }
            $output .= self::putcsv(array_dot($val));
        }
        return [$output, $filename];
    }

    public function getRow($table, $row)
    {

        switch ($table) {
            case 'users':
                $row['gender'] = $row['gender'] == 1 ? '男' : '女';
                break;
            case 'products':
                $row['shelf_id'] = Shelf::find($row['shelf_id'])->name;
                $row['points'] = $row['is_default'] == 1 ? $row['points'] : '';
                $row['status'] = $row['status'] == 1 ? '显示' : '隐藏';
                break;
            default:
                $row['gender'] = $row['gender'] == 1 ? '男' : '女';
                break;
        }
        return $row;
    }


     /**
      * Remove indexed array.
      *
      * @param array $row
      *
      * @return array
      */
    protected function sanitize(array $row)
    {
         return collect($row)->reject(function ($val) {
             return is_array($val) && !Arr::isAssoc($val);
         })->toArray();
    }
     /**
      * @param $row
      * @param string $fd
      * @param string $quot
      * @return string
      */
    protected static function putcsv($row, $fd = ',', $quot = '"')
    {
        $str = '';
        foreach ($row as $cell) {
            $cell = str_replace([$quot, "\n"], [$quot . $quot, ''], $cell);
            if (strchr($cell, $fd) !== false || strchr($cell, $quot) !== false) {
                $str .= $quot . $cell . $quot . $fd;
            } else {
                $str .= $cell . $fd;
            }
        }

        return substr($str, 0, -1) . "\n";
    }
}
