<?php

/**
 * @apiGroup           Report
 * @apiName            findReportById
 *
 * @api                {GET} /v1/reports/:id 报告详情
 * @apiDescription     报告详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse            ReportSuccessSingleResponse
 */

/** @var Route $router */
$router->get('reports/{id}', [
    'as'         => 'api_report_find_report_by_id',
    'uses'       => 'Controller@findReportById',
    'middleware' => [
        'auth:api',
    ],
]);
