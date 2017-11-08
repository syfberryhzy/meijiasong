<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\Shelf;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\UserExporter;

class ProductController extends Controller
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

            $content->header('商品');
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

            $content->header('商品');
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

            $content->header('商品');
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
        return Admin::grid(Product::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->column('shelf.name', '商品名称');
            $grid->column('shelf.attributes', '属性')->display(function ($str) {
                return '<font color="#d2d6de">'. $str. ': </font>'. $this->characters;
            });
            $grid->price('单价');
            $grid->column('shelf.image', '图片')->display(function ($image) {
                return '<img src="/uploads/'.$image[0].'" style="width:100px;height:85px;">';
            });
            $grid->sales('销量');
            $grid->column('content', '商品说明')->display(function ($content) {
                return mb_substr($content, 0, 70).'...';
            });
            $states = [
                'on'  => ['value' => 1, 'text' => 'YES', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'danger'],
            ];
            $grid->status('显示 ？')->switch($states);
            $grid->is_default('积分抵扣？')->switch($states);
            $grid->points('抵扣积分');

            $grid->created_at('创建时间');
            $grid->exporter(new UserExporter());
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
            // $filter->disableIdFilter();

            $filter->equal('shelf_id', '商品名称')->select(Shelf::all()->pluck('name', 'id'));

            $filter->equal('is_default', '积分抵扣？')->select([1 => '是', 0 => '否']);
            $filter->like('characters', '商品属性');
            $filter->equal('status', '显 示 ？')->select([1 => '是', 0 => '否']);
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
        return Admin::form(Product::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('shelf_id', '商品名称')->options(Shelf::all()->pluck('name', 'id'));
            $form->number('price', '单价（元/件）')->rules('regex:/^\d+(\.\d+)?$/')->help('价格不能为负值');
            $form->number('sales', '销量')->rules('regex:/^\d+?$/')->help('必须为正整数');
            $form->text('characters', '属性值');
            $form->textarea('content', '商品说明')->rows(10);
            $states = [
                'on'  => ['value' => 1, 'text' => 'YES', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'danger'],
            ];
            $form->switch('is_default', '积分抵扣？')->states($states);
            $form->number('points', '抵扣积分')->rules('regex:/^\d+?$/')->help('<br>[说明：每件商品允许抵扣的积分数量]<br/>[规则：]必须为正整数<br/>');
            $form->switch('status', '显 示 ？')->states($states);
        });
    }
}
