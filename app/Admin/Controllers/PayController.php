<?php

namespace App\Admin\Controllers;

use App\Models\Pay;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PayController extends Controller
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

            $content->header('支付方式');
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

            $content->header('支付方式');
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

            $content->header('支付方式');
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
        return Admin::grid(Pay::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('支付方式');
            $grid->description('说明');
            $states = [
                'on'  => ['value' => 1, 'text' => 'YES', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'danger'],
            ];
            $grid->status('启用 ？')->switch($states);
            $grid->is_deductible('抵扣积分？')->switch($states);
            $grid->is_reward('奖励积分？')->switch($states);
            $grid->proportion('积分比例')->display(function ($pro) {
                return $this->is_reward == 0 ? '<font color="#d2d6de">' . $pro . '</font>' : $pro;
            });
            $grid->created_at('创建时间');
            $grid->disableCreation();
            $grid->disableExport();
            $grid->disableFilter();
            $grid->disableRowSelector();
            // $grid->disableActions();
            $grid->actions(function ($actions) {
               #隐藏编辑按钮
                // $actions->disableEdit();
               #隐藏删除按钮
                $actions->disableDelete();
                // if ($actions->row->status == 0) {
                //     $actions->append(new ConvertTool($actions->getKey()));
                // } else {
                //     $actions->append('暂无操作');
                // }
            });

            // $this->gridSearch($grid);
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
        return Admin::form(Pay::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('name', '支付方式')->rules('required|max:20');
            $states = [
                'on'  => ['value' => 1, 'text' => 'YES', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => 'NO', 'color' => 'danger'],
            ];
            $form->text('description', '简要说明')->rules('required|max:80');
            $form->switch('status', '是否启用 ？')->states($states);
            $form->switch('is_deductible', '抵扣积分？')->states($states);
            $form->switch('is_reward', '奖励积分？')->states($states);
            $form->number('proportion', '奖励比例值')->default('1')->rules('regex:/^\d+(\.\d+)?$/|min:0.01')->help('消费多少元现金奖励1积分【数值大于0.01】');
        });
    }
}
