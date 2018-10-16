<?php

/**
 * @apiGroup           PlanDepart
 * @apiName            updatePlanDepart
 *
 * @api                {PATCH} /v1/plan_departs/:id 更新方案部门
 * @apiDescription     更新方案部门
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  name 部门名称
 * @apiParam           {String}  icon 部门图标
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('plan_departs/{id}', [
    'as'         => 'api_plan_depart_update_plan_depart',
    'uses'       => 'Controller@updatePlanDepart',
    'middleware' => [
        'auth:api',
    ],
]);
