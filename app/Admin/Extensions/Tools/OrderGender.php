<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class OrderGender extends AbstractTool
{
    public function script()
    {
        $url = Request::fullUrlWithQuery(['status' => '_status_']);

        return <<<EOT

$('input:radio.order-gender').change(function () {

    var url = "$url".replace('_status_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        $options = [
            'all'   => '全部订单',
            '1'     => '待支付',
            '21'     => '待接单',
            '22'     => '配送中',
            '3'     => '已取消',
            '4'     => '已完成',
        ];

        return view('admin.tools.gender', compact('options'));
    }
}
