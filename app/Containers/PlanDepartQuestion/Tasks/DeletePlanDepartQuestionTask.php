<?php

namespace App\Containers\PlanDepartQuestion\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Events\UpdatePlanEvent;
use App\Containers\PlanDepartQuestion\Data\Repositories\PlanDepartQuestionRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeletePlanDepartQuestionTask extends Task
{

  private $repository;

  public function __construct(PlanDepartQuestionRepository $repository)
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

          $result = $this->del_question_details(count($ids) - 1 == $key,$id);

          if (!$result) {
            break;
          }

        }


      } else {

        $result = $this->del_question_details(true,$ids);

      }

      /* 删除成功 返回成功信息，删除失败返回失败信息*/
      if ($result) {
        \DB::commit();
        return success_simple_respone('问题删除成功');
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

  /*删除问题下的进一步问题*/
  public function del_question_details($key, $id)
  {
    $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$id]);

    $question_detail_ids = $plan_depart_question->question_details->pluck('id')->toArray();
    Apiato::call('QuestionDetail@DeleteQuestionDetailTask', [$question_detail_ids]);

    $result = $this->repository->delete($id);
    if ($key && $result) {

      //更新方案编辑人和时间
      \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
        ->dispatch(new UpdatePlanEvent($plan_depart_question->plan_depart->plan));

    }

    return $result;

  }

}
