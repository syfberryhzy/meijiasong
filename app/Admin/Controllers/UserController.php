<?php

namespace App\Admin\Controllers;

use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\UserExporter;

class UserController extends Controller
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


            $content->header('用户');
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

            $content->header('用户');
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

            $content->header('用户');
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('用户名');
            $grid->avatar('头像')->display(function ($avatar) {
                return '<img src="/uploads/' . $avatar . '" style="width:100px;">';
            });
            $grid->gender('性别')->display(function ($gender) {
                return $gender == 1 ? '男' : '女';
            });
            $grid->openid('微信标识');
            $grid->integral('积分');
            $grid->balance('余额');
            $grid->status('状态');
            $grid->created_at('创建时间');
            // $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                  $actions->disableDelete();
            });
            $this->gridSearch($grid);

            #自定义导出
            $grid->exporter(new UserExporter());
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
            // $filter->disableIdFilter();

            // sql: ... WHERE `user.name` LIKE "%$name%";
            $filter->like('name', '用户名');

            // sql: ... WHERE `user.email` = $email;
            $filter->like('openid', '微信标识');

            // sql: ... WHERE `user.created_at` BETWEEN $start AND $end;
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
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '用户名');
            $form->image('avatar', '头像');
            $form->text('openid', '标识');
            $form->select('gender', '性别')->options([1=> '男', 2 => '女']);
            $form->number('integral', '积分');
            $form->number('balance', '余额');
            $form->text('lat', '经度');
            $form->text('lng', '纬度');
            $form->display('created_at', '创建时间');
        });
    }
}
