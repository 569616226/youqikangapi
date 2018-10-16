<?php

namespace App\Containers\PlanDepartQuestion\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindPlanDepartQuestionByNameTask extends Task
{

    public function run($name, $plan_depart_id)
    {
        try {

            $plan_depart = Apiato::call('PlanDepart@FindPlanDepartByIdTask', [$plan_depart_id]);

            return $plan_depart->plan_depart_questions()->whereName($name)->first();

        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
