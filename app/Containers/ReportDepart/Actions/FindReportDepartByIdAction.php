<?php

namespace App\Containers\ReportDepart\Actions;

use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Apiato\Core\Foundation\Facades\Apiato;

class FindReportDepartByIdAction extends Action
{
    public function run(Request $request)
    {
        $report_depart = Apiato::call('ReportDepart@FindReportDepartByIdTask', [$request->id]);

        return $report_depart;
    }
}
