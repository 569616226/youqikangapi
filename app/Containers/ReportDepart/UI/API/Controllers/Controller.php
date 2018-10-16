<?php

namespace App\Containers\ReportDepart\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\ReportDepart\UI\API\Requests\FindReportDepartByIdRequest;
use App\Containers\ReportDepart\UI\API\Requests\GetAllReportDepartsRequest;
use App\Containers\ReportDepart\UI\API\Transformers\ReportDepartTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\ReportDepart\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     */
    public function findReportDepartById(FindReportDepartByIdRequest $request)
    {
        $report_depart = Apiato::call('ReportDepart@FindReportDepartByIdAction', [$request]);

        return $this->transform($report_depart, ReportDepartTransformer::class);
    }

}
