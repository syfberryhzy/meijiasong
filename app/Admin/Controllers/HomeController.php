<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {
        \Auth::login(\App\Models\User::find(1));
        return Admin::content(function (Content $content) {
            $content->header('后台首页');
            $content->description('展示后台配置信息');

            // $content->row(Dashboard::title());

            // $content->row(function (Row $row) {

                // $row->column(4, function (Column $column) {
                //    $column->append(Dashboard::environment());
                // });

                // $row->column(4, function (Column $column) {
                //    $column->append(Dashboard::extensions());
                // });

                // $row->column(4, function (Column $column) {
                //    $column->append(Dashboard::dependencies());
                // });
            // });
        });
    }
}
