<?php

namespace App\Admin\Controllers;

use App\Models\Gallery;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class GalleryController extends Controller
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
            $content->header('header');
            $content->description('description');

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
            $content->header('header');
            $content->description('description');

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
            $content->header('header');
            $content->description('description');

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
        return Admin::grid(Gallery::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->name('名称')->display(function ($name) {
                if ($this->id <= ConfigModel::POINTS_ID) {
                    return "<a tabindex=\"0\" class=\"btn btn-xs btn-twitter\" role=\"button\" data-toggle=\"popover\" data-html=true title=\"Usage\" data-content=\"<code>config('$name');</code>\">$name</a>";
                } else {
                    return '<span class="label label-success">' . $name . '</span>';
                }
            });
            $grid->value('设置')->display(function ($value) {
                $images = array_map(function ($vo) {
                    return '<img src="/uploads/' . $vo . '" style="width:100px;height:100px;">';
                }, $value);
                return implode('', $images);
            });
            $grid->description('说明')->display(function ($des) {
                return $des ? '<div style="width:380px;padding:0px 10px 0px 10px;">' . $des . '</div>' : '';
            });

            $grid->created_at('创建时间');

            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('name', '名字');
                $filter->like('value', '设置');
            });
            // $grid->disableCreation();
            $grid->disableExport();
            // $grid->disableFilter();
            $grid->disableRowSelector();
            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Gallery::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('name', '名称')->rules('required');

            $form->image('value', '设置')->rules('required')->help('规则：<br>1.时间设置时请使用英文键<br/>2.时间段请使用"-"连接，如 8:00-16:00<br>3.ID从11开始，为商家公告信息');

            $form->textarea('description', '说明')->help('规则：商家地址的说明格式：“ [经度,纬度] ”');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
