<?php

/**
 * @apiGroup           ReportDepart
 * @apiName            findReportDepartById
 *
 * @api                {GET} /v1/report_departs/:id 报告部门详情
 * @apiDescription     报告部门详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 */

/** @var Route $router */
$router->get('report_departs/{id}', [
    'as'         => 'api_report_depart_find_report_depart_by_id',
    'uses'       => 'Controller@findReportDepartById',
    'middleware' => [
        'auth:api',
    ],
]);
