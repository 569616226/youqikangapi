<?php

namespace App\Containers\Report\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Report\UI\API\Requests\FindReportByIdRequest;
use App\Containers\Report\UI\API\Requests\CreateReportRequest;
use App\Containers\Report\UI\API\Transformers\ReportTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\Report\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     * @param CreateReportRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createReport(CreateReportRequest $request)
    {
        return Apiato::call('Report@CreateReportAction', [$request]);

    }


    /**
     * @param FindReportByIdRequest $request
     * @return array
     */
    public function findReportById(FindReportByIdRequest $request)
    {
        $report = Apiato::call('Report@FindReportByIdAction', [$request]);

        return $this->transform($report, ReportTransformer::class);
    }


}
