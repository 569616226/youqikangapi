<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/6
 * Time: 9:44
 */

namespace App\Containers\Wechat\Events;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Models\User;
use App\Ship\Parents\Events\Event;
use DB;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;


class BangdingEvent extends Event implements ShouldQueue
{

    /**
     * @var User $user 绑定者
     */
    protected $user;

    /**
     * @var  $client 邀请者
     */
    protected $client;


    /**
     * 实例化事件时传递这些信息
     */
    public function __construct(User $user, $client)
    {
        $this->user = $user;
        $this->client = $client;
    }

    // handle方法中处理事件
    public function handle()
    {
        $officialAccount = \EasyWeChat::officialAccount();
        $mobile_url = env('APP_MOBILE_URL', 'https://wx.check.elinkport.com');

        /*如果有邀请人*/
        if ($this->client) {
            $result_user = $officialAccount->template_message->send([
                'touser'      => $this->client->open_id,
                'template_id' => config('wechat-container.wechat_send_msg_temp_id'),
                'url'         => $mobile_url . "/#/",
                'data'        => [
                    'first'    => '有一位新的成员绑定成功！',
                    'keyword1' => $this->user->username,
                    'keyword2' => $this->user->phone,
                    'remark'   => '您邀请的好友已经绑定成功，感谢您的支持！',
                ],
            ]);

            $content_user = [
                'content' => [
                    '标题'     => '绑定成功通知',
                    'title'  => '有一位新的成员绑定成功！',
                    '姓名'     => $this->user->username,
                    '手机号码'   => $this->user->phone,
                    '生成日期'   => now()->toDateTimeString(),
                    'remark' => '您邀请的好友已经绑定成功，感谢您的支持！',
                ]
            ];

            if ($result_user['errcode'] == 0 && $result_user['errmsg'] == 'ok') {
                Apiato::call('Message@CreateMessageTask', [$content_user]);
            }
        }

        $type = $this->user->is_client ? '用户认证' : '顾问认证';
        $url = $this->user->is_client ? $mobile_url . "/#/Consultant/SelectionEnterprises" : $mobile_url . "/#/Owner/SelectReport";

        $result = $officialAccount->template_message->send([
            'touser'      => $this->user->open_id,
            'template_id' => config('wechat-container.wechat_msg_temp_id'),
            'url'         => $url,
            'data'        => [
                'first'    => '恭喜你，您已认证成功！',
                'keyword1' => $type,
                'keyword2' => now()->toDateTimeString(),
                'remark'   => '欢迎使用优企康，感谢您的使用！',
            ],
        ]);

        $content = [
            'content' => [
                'title'  => '认证成功通知',
                'first'  => '恭喜你，您已认证成功！',
                '认证类型'   => $type,
                '认证时间'   => now()->toDateTimeString(),
                'remark' => '欢迎使用优企康，感谢您的使用！',
            ]
        ];

        if ($result['errcode'] == 0 && $result['errmsg'] == 'ok') {
            Apiato::call('Message@CreateMessageTask', [$content]);
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
