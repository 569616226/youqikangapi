<?php

namespace App\Containers\Plan\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UploadPlanFromExcelAction extends Action
{
    public function run(Request $request)
    {
        $plan_excel = $request->file('plan_excel');

        $plan = Apiato::call('Plan@UploadPlanFromExcelTask', [$plan_excel]);

        return $plan;
    }
}
