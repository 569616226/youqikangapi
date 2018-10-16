<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/6
 * Time: 9:44
 */

namespace App\Containers\Report\Events;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Report\Models\Report;
use App\Containers\User\Models\User;
use App\Ship\Parents\Events\Event;
use DB;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;


class ReportEvent extends Event implements ShouldQueue
{

    /**
     * @var User $report 报告
     */
    protected $report;


    /**
     * 实例化事件时传递这些信息
     */
    public function __construct(Report $report)
    {
        $this->report = $report;

    }

    // handle方法中处理事件
    public function handle()
    {
        $officialAccount = \EasyWeChat::officialAccount();
        $mobile_url = env('APP_MOBILE_URL', 'https://wx.check.elinkport.com');

        $result = $officialAccount->template_message->send([
            'touser'      => $this->report->order->company->users()->where('is_client_admin', 1)->first()->open_id,
            'template_id' => config('report-container.wechat_report_msg_temp_id'),
            'url'         => $mobile_url . "/#/Owner/ReportIndex/" . $this->report->getHashedKey(),
            'data'        => [
                'first'    => '您好，您有一份新的诊断报告生成',
                'keyword1' => $this->report->order->name,
                'keyword2' => $this->report->order->order_number,
                'keyword3' => now()->toDateTimeString(),
                'remark'   => '点击“详情”，即可查看诊断报告的结果！',
            ],
        ]);

        $content = [
            'content' => [
                '标题'     => '报告生成成功',
                'title'  => '您好，您有一份新的诊断报告生成',
                '检测项目'   => $this->report->order->name,
                '报告编号'   => $this->report->order->order_number,
                '生成日期'   => now()->toDateTimeString(),
                'remark' => '点击“详情”，即可查看诊断报告的结果！',
            ]
        ];

        if ($result['errcode'] == 0 && $result['errmsg'] == 'ok') {

            Apiato::call('Message@CreateMessageTask', [$content]);

        } else {

            /*打印微信模板消息错误*/
            report($result);

        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-default');
    }
}
