<?php

/**
 * @apiGroup           Plan
 * @apiName            getAllPlans
 *
 * @api                {GET} /v1/plans 方案列表
 * @apiDescription     方案列表
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse        PlanSuccessSingleResponse
 *
 */

/** @var Route $router */
$router->get('plans', [
    'as'         => 'api_plan_get_all_plans',
    'uses'       => 'Controller@getAllPlans',
    'middleware' => [
        'auth:api',
    ],
]);
