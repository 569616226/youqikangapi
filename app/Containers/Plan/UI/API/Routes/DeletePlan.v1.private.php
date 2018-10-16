<?php

/**
 * @apiGroup           Plan
 * @apiName            deletePlan
 *
 * @api                {DELETE} /v1/plans/:id 删除方案
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->delete('plans/{id}', [
    'as'         => 'api_plan_delete_plan',
    'uses'       => 'Controller@deletePlan',
    'middleware' => [
        'auth:api',
    ],
]);
