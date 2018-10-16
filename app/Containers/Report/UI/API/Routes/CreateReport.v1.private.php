<?php

/**
 * @apiGroup           Report
 * @apiName            createReport
 *
 * @api                {POST} /v1/orders/{id}/create_reports 生成报告
 * @apiDescription      生成报告
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆
 *
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('orders/{id}/create_reports', [
    'as'         => 'api_report_create_report',
    'uses'       => 'Controller@createReport',
    'middleware' => [
        'auth:api',
    ],
]);
