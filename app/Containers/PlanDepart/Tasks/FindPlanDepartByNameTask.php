<?php

namespace App\Containers\PlanDepart\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindPlanDepartByNameTask extends Task
{

    public function run($name, $plan_id)
    {
        try {

            $plan = Apiato::call('Plan@FindPlanByIdTask', [$plan_id]);

            return $plan->plan_departs()->whereName($name)->first();

        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
