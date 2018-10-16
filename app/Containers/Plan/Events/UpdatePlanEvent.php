<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/6
 * Time: 9:44
 */

namespace App\Containers\Plan\Events;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Models\Plan;
use App\Containers\User\Models\User;
use App\Ship\Parents\Events\Event;
use DB;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;


class UpdatePlanEvent extends Event implements ShouldQueue
{

  /**
   * @var User $user 绑定者
   */
  protected $plan;

  /**
   * 实例化事件时传递这些信息
   */
  public function __construct(Plan $plan)
  {
    $this->plan = $plan;
  }

  // handle方法中处理事件
  public function handle()
  {
    /*如果是标准库修改，增加编辑人修改*/

    if ($this->plan->is_parent) {

      $plan = Apiato::call('Plan@UpdatePlanTask', [
        $this->plan->id,
        [
          'name'   => $this->plan->name,
          'editer' => \Auth::user()->username
        ]
      ]);

      if (!$plan instanceof Plan) {
        return error_simple_respone();
      }

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
