<?php

namespace App\Admin\Controllers;

use App\Models\Address;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AddressController extends Controller
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

            $content->header('地址');
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

            $content->header('地址');
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

            $content->header('地址');
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
        return Admin::grid(Address::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->created_at();
            $grid->updated_at();
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

            // sql: ... WHERE `user.name` LIKE "%$name%";
            $filter->like('name', 'name');

            // sql: ... WHERE `user.email` = $email;
            $filter->equal('emial', 'Email');

            // sql: ... WHERE `user.created_at` BETWEEN $start AND $end;
            $filter->between('created_at', 'Created Time')->datetime();

            // sql: ... WHERE `author_id` = $id;
            $filter->equal('author_id', 'Author')->select(User::all()->pluck('name', 'id'));

            // sql: ... WHERE `title` LIKE "%$input" OR `content` LIKE "%$input";
            $filter->where(function ($query) {

                $query->where('title', 'like', "%{$this->input}%")
                    ->orWhere('content', 'like', "%{$this->input}%");
            }, 'Text');

            // sql: ... WHERE `rate` >= 6 AND `created_at` = {$input};
            $filter->where(function ($query) {

                $query->whereRaw("`rate` >= 6 AND `created_at` = {$this->input}");
            }, 'Text');

            // 关系查询，查询对应关系`profile`的字段
            $filter->where(function ($query) {
                $input = $this->input;

                $query->whereHas('profile', function ($query) use ($input) {
                    $query->where('address', 'like', "%{$input}%")->orWhere('email', 'like', "%{$input}%");
                });
            }, '地址或手机号');
          });
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Address::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
