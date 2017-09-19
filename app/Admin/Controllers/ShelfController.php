<?php

namespace App\Admin\Controllers;

use App\Models\Shelf;
use App\Models\Category;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ShelfController extends Controller
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

            $content->header('货架');
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

            $content->header('货架');
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

            $content->header('货架');
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
        return Admin::grid(Shelf::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('商品名称');
            $grid->column('category.title', '所属分类');
            $grid->image('图片')->display(function ($image) {
                return '<img src="/uploads/' . $image . '" style="width:150px;">';
            });
            $grid->attributes('商品属性');
            $states = [
                'on'  => ['value' => 1, 'text' => 'YES'],
                'off' => ['value' => 0, 'text' => 'NO'],
            ];
            $grid->status('上架？')->switch($states);
            $grid->created_at('创建时间');
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
            $filter->like('name', '商品名称');
            $filter->like('attributes', '商品属性');
            $filter->equal('category_id', '所属分类')->select(Category::all()->pluck('title', 'id'));
            $filter->equal('status', '是否上架？')->select([1 => '是', 0 => '否']);
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
        return Admin::form(Shelf::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '商品名称')->help('<br/> 分类为充值时，商品名称为充值金额，例如：50');
            $form->select('category_id', '所属分类')->options(Category::all()->pluck('title', 'id'));
            $form->text('attributes', '商品属性')->help('<br/> 该属性为单一属性');
            $form->image('image', '上传图片');
            $states = [
                'on'  => ['value' => 1, 'text' => 'YES', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'danger'],
            ];
            $form->switch('status', '上  架 ？ ')->states($states);
        });
    }
}
