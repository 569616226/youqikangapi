<?php

/**
 * @apiGroup           Plan
 * @apiName            findPlanById
 *
 * @api                {GET} /v1/plans/:id 方案详情(其他库公用接口)
 * @apiDescription     诊断方案详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse        PlanSuccessSingleResponse
 */

/** @var Route $router */
$router->get('plans/{id}', [
    'as'         => 'api_plan_find_plan_by_id',
    'uses'       => 'Controller@findPlanById',
    'middleware' => [
        'auth:api',
    ],
]);
