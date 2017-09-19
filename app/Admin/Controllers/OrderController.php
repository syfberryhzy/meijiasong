<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Pay;
use App\Models\Integral;
use App\Models\Balance;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\Tools\OrderGender;
use App\Admin\Extensions\Tools\OrderTool;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;

class OrderController extends Controller
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

            $content->header('订单');
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

            $content->header('订单');
            $content->description('详情');

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

            $content->header('订单');
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
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->model()->gender(request()->get('status'))->orderby('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->column('user.name', '用户名');
            $grid->column('pay.name', '支付方式');

            $grid->status('订单状态')->display(function ($status) {
                $profile = [
                  '1' => '待支付',
                  '21' => '待接单',
                  '22' => '配送中',
                  '31' => '用户取消',
                  '32' => '后台取消',
                  '41' => '配送完成',
                  '42' => '确认收货',
                ];
                return $profile[$status];
            });

            $grid->column('totalprice', ' 付  款 ')->display(function () {
                if ($this->is_discount == 1) {
                    $dis = '<span style="color:rgb(39, 35, 35);">是</span>';
                    $discount = '<a href="/admin/usergroup/integrals?order_id='. $this->id .'">' . $this->discount . '</a>';
                } else {
                    $dis = '<span style="color:rgb(92, 184, 92);">否</span>';
                    $discount = $this->discount;
                }
                return '<b>订单金额：</b> ' . $this->total .'<br/>'.'<b>抵扣积分：</b> ' . $dis .'<br/>'.'<b>抵扣金额：</b> ' . $discount .'<br/><b>支付金额：</b> ' . $this->total .'<br/>';
            });
            $grid->column('order_receiver', '收货信息')->display(function ($form) {
                return '<b>收货人：</b>' . $this->receiver .'<br/>'.'<b>电  话 : </b>' . $this->phone .'<br/>'.'<b>地   址 : </b>' . $this->address .'<br/>';
            });

            $grid->column('items', '采购详情')->expand(function () {
                $items = $this->items->toArray();
                $headers = ['ID', '商品', '属性', '单价', '数量', '总计'];
                $title = ['id', 'name', 'attributes', 'price', 'number', 'amount'];
                $datas = array_map(function ($item) use ($title) {
                    return array_only($item, $title);
                }, $items);
                return new Table($headers, $datas);
            }, '采购详情');
            $grid->created_at('创建时间');
            #取消订单-》退款
            #订单详情orderitem
            $grid->disableCreation();
            $grid->actions(function ($actions) {
                #隐藏编辑按钮
                $actions->disableEdit();
                #隐藏删除按钮
                $actions->disableDelete();
                #订单详情
                $actions->append('&nbsp;<a href="/admin/orders/order_items?order_id='. $actions->row->id .'"><i class="fa fa-search-plus "></i>详情</a>');
                #订单 接单、取消。确认收货
                if ($actions->row->status == 21) {
                    $actions->append(new OrderTool($actions->getKey(), 1));
                    $actions->append(new OrderTool($actions->getKey(), 2));
                } elseif ($actions->row->status == 22) {
                    $actions->append(new OrderTool($actions->getKey(), 3));
                }
            });
            $grid->tools(function ($tools) {
                 $tools->append(new OrderGender());
            });
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
            $filter->where(function ($query) {
                $input = $this->input;
                $query->whereHas('users', function ($query) use ($input) {
                    $query->where('name', 'like', "%{$input}%");
                });
            }, '用户名');
            $filter->where(function ($query) {
                $input = $this->input;
                $query->where('receiver', 'like', "%{$input}%")->orwhere('phone', 'like', "%{$input}%")->orwhere('address', 'like', "%{$input}%");
            }, '收货人或电话或收货地址');
            $filter->equal('pay_id', '支付方式')->select(Pay::all()->pluck('name', 'id'));
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
        return Admin::form(Order::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('user_id', '用户名')->options(User::all()->pluck('name', 'id'));
            $form->select('pay_id', '支付方式')->options(Pay::all()->pluck('name', 'id'));
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
    /**
     * 订单处理操作 接单，取消，确认
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function operate(Request $request)
    {
        $order = Order::find($request->id);
        if ($request->action == 1) {
            return $this->accept($order);
        } elseif ($request->action == 2) {
            return $this->cancel($order);
        } elseif ($request->action == 3) {
            return $this->confirm($order);
        }
        return response()->json(['message' => '操作失败!', 'status' => 0], 201);
    }

    public function accept($order)
    {
        if ($order->status == 21) {
            $order->status = 22;
            if ($order->save()) {
                return response()->json(['message' => '订单已接单', 'status' => 1], 201);
            }
            return response()->json(['message' => '操作失败!', 'status' => 0], 201);
        }
        return response()->json(['message' => '操作失败!', 'status' => 0], 201);
    }

    public function confirm($order)
    {
        if ($order->status == 22) {
            $order->status = 42;
            if ($order->save()) {
                return response()->json(['message' => '订单已完成', 'status' => 1], 201);
            }
            return response()->json(['message' => '操作失败!', 'status' => 0], 201);
        }
        return response()->json(['message' => '操作失败!', 'status' => 0], 201);
    }
    public function cancel($order)
    {
        $user = User::find($order->user_id);
        if ($order->status != 21) {
            return response()->json(['message' => '操作失败!', 'status' => 0], 201);
        }
        if ($order->is_discount == 1 && $order->discount > 0) {
          #反退 消耗积分，奖励积分
            $intelogs = Integral::where('order_id', $oreder->id)->where('user_id', $user->id)->get()->toArray();
            $datas = [];
            foreach ($intelogs as $key => $inte) {
                if ($inte['type'] != 3) {
                    $inte['type'] = $inte['type'] == 1 ? 2 : 1;
                    $inte['before'] = $user->integral;
                    $inte['desc'] = $inte['type'] == 1 ?  '订单取消，退回抵扣积分': '订单取消，退回奖励积分';
                    $inte['current'] = $inte['type'] == 1 ? ($inte['before'] + $inte['number']) : ($inte['before'] - $inte['number']);
                    $datas[] = array_only($inte, ['user_id', 'order_id', 'type', 'number', 'before', 'current', 'desc']);
                }
            }
            Integral::create($data);
        }
        if ($order->pay_id == Pay::PAY_YUE_ID) {
           #退余额
             $balance = Balance::balance()->toArray();
             $balance['type'] = $balance['type'] == 1 ? 2 : 1;
             $balance['before'] = $user->balance;
             $balance['desc'] = $inte['type'] == 1 ?  '订单取消，退回消费余额': '订单取消，退回奖励余额';
             $inte['current'] = $inte['type'] == 1 ? ($inte['before'] + $inte['number']) : ($inte['before'] - $inte['number']);
             $data = array_only($inte, ['user_id', 'order_id', 'type', 'number', 'before', 'current', 'desc']);
             Balance::create($data);
        } elseif ($order->pay_id == Pay::PAY_WEIXIN_ID) {
           #微信退款 商户平台退款
          // $order->amount;
        }
        $order->status = 32;
        if ($order->save()) {
            return response()->json(['message' => '订单已取消', 'status' => 1], 201);
        }
        return response()->json(['message' => '操作失败!', 'status' => 0], 201);
    }
}
