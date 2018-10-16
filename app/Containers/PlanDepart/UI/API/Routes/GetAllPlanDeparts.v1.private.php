<?php

/**
 * @apiGroup           PlanDepart
 * @apiName            getAllPlanDeparts
 *
 * @api                {GET} /v1/plan/:plan_id/departs   方案部门列表
 * @apiDescription     方案部门列表
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse              PlanDepartSuccessSingleResponse
 */

/** @var Route $router */
$router->get('plan/{id}/departs', [
    'as'         => 'api_plan_depart_get_all_plan_departs',
    'uses'       => 'Controller@getAllPlanDeparts',
    'middleware' => [
        'auth:api',
    ],
]);
