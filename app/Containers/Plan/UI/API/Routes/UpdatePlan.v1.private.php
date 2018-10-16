<?php

/**
 * @apiGroup           Plan
 * @apiName            updatePlan
 *
 * @api                {PATCH} /v1/plans/:id 方案更新
 * @apiDescription     方案更新
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  name 方案名称
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('plans/{id}', [
    'as'         => 'api_plan_update_plan',
    'uses'       => 'Controller@updatePlan',
    'middleware' => [
        'auth:api',
    ],
]);
