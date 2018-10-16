<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/6
 * Time: 9:44
 */

namespace App\Containers\Authentication\Events;

use App\Containers\User\Models\User;
use App\Ship\Parents\Events\Event;
use DB;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Jenssegers\Agent\Agent;
use Zhuzhichao\IpLocationZh\Ip;

class LoginEvent extends Event implements ShouldQueue
{

    /**
     * @var User 用户模型
     */
    protected $user;

    /**
     * @var Agent Agent对象
     */
    protected $agent;

    /**
     * @var string IP地址
     */
    protected $ip;

    /**
     * @var int 登录时间戳
     */
    protected $timestamp;

    /**
     * 实例化事件时传递这些信息
     */
    public function __construct(User $user, Agent $agent, $ip)
    {
        $this->user = $user;
        $this->agent = $agent;
        $this->ip = $ip;
        $this->timestamp = now();
    }

    // handle方法中处理事件
    public function handle()
    {
        //获取事件中保存的信息
        $user = $this->user;
        $agent = $this->agent;
        $ip = $this->ip;
        $timestamp = $this->timestamp;

        //登录信息
        $login_info = [
            'ip'                => $ip,
            'created_at'        => $timestamp,
            'updated_at'        => $timestamp,
            'revisionable_type' => 'App\\Containers\\User\\Models\\User',
            'revisionable_id'   => $user->id,
            'key'               => 'login',
            'user_id'           => $user->id
        ];

        // zhuzhichao/ip-location-zh 包含的方法获取ip地理位置
        $addresses = Ip::find($ip);
        $login_info['address'] = implode(' ', $addresses);

        // jenssegers/agent 的方法来提取agent信息
        $login_info['device'] = $agent->device(); //设备名称
        $browser = $agent->browser();
        $login_info['browser'] = $browser . ' ' . $agent->version($browser); //浏览器
        $platform = $agent->platform();
        $login_info['platform'] = $platform . ' ' . $agent->version($platform); //操作系统
        $login_info['language'] = implode(',', $agent->languages()); //语言

        //设备类型
        if ($agent->isTablet()) {
            // 平板
            $login_info['device_type'] = 'tablet';
        } else if ($agent->isMobile()) {
            // 便捷设备
            $login_info['device_type'] = 'mobile';
        } else if ($agent->isRobot()) {
            // 爬虫机器人
            $login_info['device_type'] = 'robot';
            $login_info['device'] = $agent->robot(); //机器人名称
        } else {
            // 桌面设备
            $login_info['device_type'] = 'desktop';
        }

        //插入到数据库
        DB::table('revisions')->insert($login_info);
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
