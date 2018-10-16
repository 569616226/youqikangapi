<?php

namespace App\Containers\Plan\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Data\Repositories\PlanRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeletePlanTask extends Task
{

    private $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {

        try {

            \DB::beginTransaction();

            $plan = Apiato::call('Plan@FindPlanByIdTask', [$id]);
            /*
              * 判断是否可以删除
              *
              * 如果不可以删除返回提示信息
              */
            $is_del = is_del_plan($plan);

            if (is_string($is_del)) {

                \DB::rollback();
                return error_simple_respone($is_del);

            }

            /*删除方案下部门*/
            $plan_depart_ids = $plan->plan_departs->pluck('id')->toArray();
            Apiato::call('PlanDepart@DeletePlanDepartTask', [$plan_depart_ids]);

            /*
             * 删除订单 未开始的订单
            */
            if ($plan->order) {
                Apiato::call('Order@DeleteOrderTask', [$plan->order->id]);
            }

            $result = $this->repository->delete($id);

            if ($result) {

                \DB::commit();
                return success_simple_respone($plan->name . ' 方案删除成功');

            } else {

                \DB::rollback();
                return error_simple_respone();

            }

        } catch (Exception $exception) {

            report($exception);
            \DB::rollback();
            throw new DeleteResourceFailedException();

        }
    }
}
