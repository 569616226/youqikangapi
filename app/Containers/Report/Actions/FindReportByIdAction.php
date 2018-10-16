<?php

namespace App\Containers\Report\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindReportByIdAction extends Action
{
    public function run(Request $request)
    {
        $report = Apiato::call('Report@FindReportByIdTask', [$request->id]);

        return $report;
    }
}
