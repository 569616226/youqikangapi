<?php

namespace App\Containers\Plan\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindParentPlanAction extends Action
{
    public function run()
    {
        $plan = Apiato::call('Plan@FindParentPlanTask');

        return $plan;
    }
}
