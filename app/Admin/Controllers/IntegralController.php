<?php

namespace App\Admin\Controllers;

use App\Models\Integral;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class IntegralController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('积分明细');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('积分明细');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('积分明细');
            $content->description('添加');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Integral::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->column('order_id', '订单ID')->display(function ($orderid) {
                return '<a href="/admin/orders/order_menus?id=' . $orderid . '"><i class="fa">' . $orderid . '</i></a>';
            });
            $grid->column('user.name', '用户名')->display(function ($username) {
                return '<a href="/admin/usergroup/users?id=' . $this->user_id . '"><i class="fa">' . $username . '</i></a>';
            });
            $grid->type('方式')->display(function ($type) {
                if ($type == 1) {
                    return  '<span style="color:rgb(92, 184, 92);">奖励</span>';
                } elseif ($type == 2) {
                    return  '<span style="color:rgb(217, 83, 79);">抵扣</span>';
                } elseif ($type == 3) {
                    return  '<span style="color:#00acd6;">退回</span>';
                }
                return $type;
            });
            $grid->before('变动前');
            $grid->current('变动后');
            $grid->desc('备注');
            $grid->created_at('创建时间');
            $this->gridSearch($grid);
            $grid->disableCreation();
            $grid->disableActions();
            $grid->disableExport();
            $grid->disableRowSelector();
        });
    }

    /**
     * 查询过滤
     * @param  [type] $grid [description]
     * @return [type]       [description]
     */
    public function gridSearch($grid)
    {
        $grid->filter(function ($filter) {
            // 如果过滤器太多，可以使用弹出模态框来显示过滤器.
            $filter->useModal();

            // 禁用id查询框
            $filter->disableIdFilter();

            $filter->equal('order_id', '订单ID');
            $filter->equal('type', '方式')->select([1 => '奖励', 2 => '抵扣', 3 => '退回']);
            $filter->equal('user_id', '用户名')->select(User::all()->pluck('name', 'id'));
            $filter->between('created_at', '创建时间')->datetime();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Integral::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
