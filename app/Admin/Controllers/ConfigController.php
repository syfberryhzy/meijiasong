<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Models\AdminConfig as ConfigModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ConfigController
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
            $content->header('商家设置');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('商家设置');
            $content->description('编辑');
            $content->body($this->form($id)->edit($id));
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
            $content->header('商家设置');
            $content->description('添加');

            $content->body($this->form());
        });
    }

    public function grid()
    {
        return Admin::grid(ConfigModel::class, function (Grid $grid) {
            // $grid->id('ID')->sortable();
            $grid->name('名称')->display(function ($name) {
                if ($this->id <= ConfigModel::POINTS_ID) {
                    return "<a tabindex=\"0\" class=\"btn btn-xs btn-twitter\" role=\"button\" data-toggle=\"popover\" data-html=true title=\"Usage\" data-content=\"<code>config('$name');</code>\">$name</a>";
                } else {
                    return '<span class="label label-success">' . $name . '</span>';
                }
            });
            $grid->value('设置')->display(function ($value) {
                if (preg_match('/(.*?(jpg|jpeg|gif|png))/', $value)) {
                    return '<img src="' . config('app.url') . '/uploads/' . $value . '" style="witdh:90px;height:90px;">';
                }
                return $this->value;
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
            $grid->actions(function ($actions) {
                $text = 'textarea';
                if ($actions->row->id < ConfigModel::POINTS_ID) {
                    $actions->disableDelete();
                }

                $images = [10, 11, 12, 13];
                if (in_array($actions->row->id, $images)) {
                    $text = 'image';
                }
                $actions->disableEdit();
                $actions->append('<a href="/admin/config/' . $actions->row->id . '/edit?slug=' . $text . '"><i class="fa fa-edit"></i></a>');
            });
        });
    }

    public function form($id = '')
    {
        return Admin::form(ConfigModel::class, function (Form $form) use ($id) {
            $form->display('id', 'ID');
            $form->text('name', '名称')->rules('required');
            $url = request('_previous_') ?: request()->fullUrl();

            if (isset(parse_url($url)['query'])) {
                $query = parse_url($url, PHP_URL_QUERY);
                parse_str($query, $data);
                if (isset($data['slug'])) {
                    $slug = $data['slug'];
                    $form->$slug('value', '设置');
                } else {
                    $form->textarea('value', '设置')->rules('required')->help('规则：<br>1.时间设置时请使用英文键<br/>2.时间段请使用"-"连接，如 8:00-16:00<br>3.ID从11开始，为商家公告信息');
                }
            } else {
                $request = request()->all();
                if ($request['value'] instanceof UploadedFile) {
                    $form->image('value', '设置')->rules('required')->help('规则：商家图片,第一张默认为logo图片');
                } else {
                    $form->textarea('value', '设置')->rules('required')->help('规则：<br>1.时间设置时请使用英文键<br/>2.时间段请使用"-"连接，如 8:00-16:00<br>3.ID从11开始，为商家公告信息');
                }
            }
            $form->textarea('description', '说明')->help('规则：商家地址的说明格式：“ [经度,纬度] ”');
        });
    }
}
