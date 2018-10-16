<?php

namespace App\Containers\PlanDepart\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Events\UpdatePlanEvent;
use App\Containers\PlanDepart\Data\Repositories\PlanDepartRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeletePlanDepartTask extends Task
{

  private $repository;

  public function __construct(PlanDepartRepository $repository)
  {
    $this->repository = $repository;
  }

  public function run($ids)
  {
    try {

      \DB::beginTransaction();

      $result = false;
      if (is_array($ids)) {

        foreach ($ids as $key => $id) {

          $result = $this->del_plan_depart_questions(count($ids) - 1 == $key, $id);

          if (!$result) {
            break;
          }

        }

      } else {

        $result = $this->del_plan_depart_questions(true,$ids);

      }

      /* 删除成功 返回成功信息，删除失败返回失败信息*/
      if ($result) {

        \DB::commit();
        return success_simple_respone('部门删除成功');

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

  /**
   *删除部门下问题
   *
   * @param $plan_depart
   */
  protected function del_plan_depart_questions($key, $id)
  {

    $plan_depart = Apiato::call('PlanDepart@FindPlanDepartByIdTask', [$id]);

    $plan_depart_question_ids = $plan_depart->plan_depart_questions->pluck('id')->toArray();
    Apiato::call('PlanDepartQuestion@DeletePlanDepartQuestionTask', [$plan_depart_question_ids]);

    $result = $this->repository->delete($id);
    if ($key && $result) {

      //更新方案编辑人和时间
      \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
        ->dispatch(new UpdatePlanEvent($plan_depart->plan));

    }

    return $result;
  }

}
