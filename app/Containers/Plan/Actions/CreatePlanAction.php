<?php

namespace App\Containers\Plan\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreatePlanAction extends Action
{
    public function run(Request $request)
    {

        return Apiato::call('Plan@CreatePlanTask', [$request->plan_data]);

    }
}
