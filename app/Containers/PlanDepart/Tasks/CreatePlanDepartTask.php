<?php

namespace App\Containers\PlanDepart\Tasks;

use App\Containers\Plan\Events\UpdatePlanEvent;
use App\Containers\PlanDepart\Data\Repositories\PlanDepartRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreatePlanDepartTask extends Task
{

    private $repository;

    public function __construct(PlanDepartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data)
    {
        try {

          $plan_depart = $this->repository->create($data);

          //更新方案编辑人和时间
          if($plan_depart){

            \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
              ->dispatch(new UpdatePlanEvent($plan_depart->plan));

              return $plan_depart;

          }else{

            return error_simple_respone();

          }

        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }
    }
}
