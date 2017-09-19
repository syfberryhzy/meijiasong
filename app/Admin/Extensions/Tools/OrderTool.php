<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;
use Encore\Admin\Admin;

class OrderTool extends BatchAction
{
    protected $id;
    protected $action;

    public function __construct($id = 1, $action = true)
    {
        $this->id = $id;
        $this->action = $action;
    }

    public function script()
    {
        return <<<EOT

        $('.orderaction').on('click', function () {

            console.log($(this).data('id'));
            var id = $(this).data('id');
            var action = $(this).data('action');

            $.ajax({
                method: 'post',
                url: '/admin/orders/order_menus/operate',
                data: {
                    _token:LA.token,
                    id: id,
                    action:action
                },
                success: function (res) {
                    $.pjax.reload('#pjax-container');
                    if (res.status == 1) {
                      toastr.success(res.message);
                    } else {
                      toastr.warning(res.message);
                    }
                }
            });

        });

EOT;
    }

    protected function render()
    {
        Admin::script($this->script());
        if ($this->action == 1) {
            return '<button type="button" class="btn btn-info btn-xs orderaction" data-id="'. $this->id .'" data-action="'. $this->action .'"><i class="fa fa-save"></i>&nbsp;接单</button>';
        } elseif ($this->action == 2) {
            return '<button type="button" class="btn btn-warning btn-xs orderaction" data-id="'. $this->id .'" data-action="'. $this->action .'"><i class="fa fa-save"></i>&nbsp;取消</button>';
        } elseif ($this->action == 3) {
            return '<button type="button" class="btn btn-info btn-xs orderaction" data-id="'. $this->id .'" data-action="'. $this->action .'"><i class="fa fa-save"></i>&nbsp;完成</button>';
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}
