<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;
use Log;

class CancelOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 5;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
         $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('回调Cancel--start', $this->order['status']);
        if ($this->order['status'] == '1') {
            #取消订单
            \Log::info('回调order--update');
            $this->order->update([
                'status' => 31
            ]);
            \Log::info('回调order-end');
        }
        \Log::info('回调Cancel--end');
    }
}
