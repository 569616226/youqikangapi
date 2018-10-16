<?php

/**
 * @apiGroup           PlanDepart
 * @apiName            findPlanDepartById
 *
 * @api                {GET} /v1/plan_departs/:id 方案部门详情
 * @apiDescription     方案部门详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse              PlanDepartSuccessSingleResponse
 */

/** @var Route $router */
$router->get('plan_departs/{id}', [
    'as'         => 'api_plan_depart_find_plan_depart_by_id',
    'uses'       => 'Controller@findPlanDepartById',
    'middleware' => [
        'auth:api',
    ],
]);
