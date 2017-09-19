<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\OrderItem;
use App\Models\Order;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class OrderItemController extends Controller
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
            $content->header('订单详情');
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

            $content->header('订单详情');
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

            $content->header('订单详情');
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
        return Admin::grid(OrderItem::class, function (Grid $grid) {
            // dd($grid, request()->path());
            $grid->id('ID')->sortable();
            $grid->order_id('订单编号');
            $grid->column('user.name', '用户名');
            $grid->name('商品名称 [属性]')->display(function ($name) {
                return '<b>'. $name . '</b> [ ' . $this->attributes . ' ]';
            });
            $grid->price('单价');
            $grid->number('数量');
            $grid->amount('总计');
            $grid->created_at('创建时间');
            $grid->disableCreation();
            $grid->disableActions();
            $grid->disableExport();
            $grid->disableRowSelector();
            $this->gridSearch($grid);
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
            $filter->like('name', '商品名称');
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
        return Admin::form(OrderItem::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
