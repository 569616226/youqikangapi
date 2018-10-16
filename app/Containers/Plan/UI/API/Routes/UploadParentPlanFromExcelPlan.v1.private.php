<?php

/**
 * @apiGroup           Plan
 * @apiName            uploadParentPlan
 *
 * @api                {PUT} /v1/upload_parent_plan_excel 导入标准方案库
 * @apiDescription     从excel导入标准方案库
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  plan_excel
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->put('upload_parent_plan_excel', [
    'as'         => 'api_plan_updload_plan_from_excel',
    'uses'       => 'Controller@uploadPlanFromExcel',
    'middleware' => [
        'auth:api',
    ],
]);
