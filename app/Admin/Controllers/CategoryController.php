<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CategoryController extends Controller
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
            $content->header('分类');
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
            $content->header('分类');
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
            $content->header('分类');
            $content->description('添加');

            $content->body($this->form());
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
            $filter->like('title', '类名');
            $filter->like('description', '说明');
            $filter->equal('type', '实物？')->select([1 => '是', 2 => '否']);
            $filter->equal('status', '显示？')->select([1 => '是', 0 => '否']);
            $filter->between('created_at', '创建时间')->datetime();
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Category::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->column('title', '类名');
            $grid->description('说明');

            $states = [
                'on' => ['value' => 1, 'text' => 'YES'],
                'off' => ['value' => 0, 'text' => 'NO'],
            ];
            $grid->type(' 实物？')->switch($states);
            $grid->status('显示？')->switch($states);
            $grid->created_at('创建时间');
            $grid->disableExport();
            $grid->disableRowSelector();
            // $grid->disableActions();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                if ($actions->row->id == 1) {
                    $actions->disableEdit();
                }
            });
            $this->gridSearch($grid);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Category::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('title', '类名');
            $form->text('description', '说明');
            $states = [
                'on' => ['value' => 1, 'text' => 'YES', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'danger'],
            ];
            $form->switch('type', '实 物 ？ ')->states($states);
            $form->switch('status', '显 示 ？ ')->states($states);
        });
    }
}
