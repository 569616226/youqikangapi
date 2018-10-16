<?php

/**
 * @apiGroup           PlanDepart
 * @apiName            deletePlanDepart
 *
 * @api                {DELETE} /v1/plan_departs/:id 删除方案部门
 * @apiDescription     删除方案部门
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->delete('plan_departs/{id}', [
    'as'         => 'api_plan_depart_delete_plan_depart',
    'uses'       => 'Controller@deletePlanDepart',
    'middleware' => [
        'auth:api',
    ],
]);
