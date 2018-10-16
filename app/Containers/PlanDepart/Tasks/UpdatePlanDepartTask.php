<?php

namespace App\Containers\PlanDepart\Tasks;

use App\Containers\Plan\Events\UpdatePlanEvent;
use App\Containers\Plan\Models\Plan;
use App\Containers\PlanDepart\Data\Repositories\PlanDepartRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class UpdatePlanDepartTask extends Task
{

  private $repository;

  public function __construct(PlanDepartRepository $repository)
  {
    $this->repository = $repository;
  }

  public function run($id, array $data)
  {
    try {

      $plan_depart = $this->repository->update($data, $id);

      //更新方案编辑人和时间

      if($plan_depart){

        $result = \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
          ->dispatch(new UpdatePlanEvent($plan_depart->plan));

        if(!$result){
          return error_simple_respone();
        }

      }

      return $plan_depart;

    } catch (Exception $exception) {

      report($exception);
      throw new UpdateResourceFailedException();
    }
  }
}
