<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/6
 * Time: 9:44
 */

namespace App\Containers\User\Events;

use App\Containers\User\Models\User;
use App\Ship\Parents\Events\Event;
use Illuminate\Contracts\Queue\ShouldQueue;


class FrozenUserEvent extends Event implements ShouldQueue
{

    use BroadcastHttpPush;

    /**
     * @var User $user 绑定者
     */
    protected $user;

    /**
     * 实例化事件时传递这些信息
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $broadcastChannel = array(
            "channel" => 'user.'.$this->user->getHashedKey(),   // 通道名，`private-`表示私有
            "name" => "private.frozen_user",    // 事件名
            "data" => array(
                "id" => $this->user->getHashedKey(),
                "is_frozen" => $this->user->is_frozen
            )
        );

        $this->push($broadcastChannel);
    }

}
