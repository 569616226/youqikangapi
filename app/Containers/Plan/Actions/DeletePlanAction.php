<?php

namespace App\Containers\Plan\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeletePlanAction extends Action
{
    public function run(Request $request)
    {
        return Apiato::call('Plan@DeletePlanTask', [$request->id]);
    }
}
