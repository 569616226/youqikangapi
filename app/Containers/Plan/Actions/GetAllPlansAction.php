<?php

namespace App\Containers\Plan\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllPlansAction extends Action
{
    public function run(Request $request)
    {
        $plans = Apiato::call('Plan@GetAllPlansTask', [true], [
            'ordered',
            'generals',
        ]);

        return $plans;
    }
}
