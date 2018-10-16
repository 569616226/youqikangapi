<?php

/**
 * @apiGroup           Plan
 * @apiName            findParentPlan
 *
 * @api                {GET} /v1/parent_plan 方案详情(标准库)
 * @apiDescription     诊断方案详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse        PlanSuccessSingleResponse
 */

/** @var Route $router */
$router->get('parent_plan', [
    'as'         => 'api_plan_find_parent_plan',
    'uses'       => 'Controller@findParentPlan',
    'middleware' => [
        'auth:api',
    ],
]);
