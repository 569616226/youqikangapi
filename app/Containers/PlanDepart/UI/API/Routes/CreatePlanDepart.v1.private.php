<?php

/**
 * @apiGroup           PlanDepart
 * @apiName            createPlanDepart
 *
 * @api                {POST} /v1/plan_departs 方案部门创建
 * @apiDescription     方案部门创建
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  name 部门名称
 * @apiParam           {String}  icon 部门图标
 * @apiParam           {Number}  plan_id 诊断方案id
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('plan_departs', [
    'as'         => 'api_plan_depart_create_plan_depart',
    'uses'       => 'Controller@createPlanDepart',
    'middleware' => [
        'auth:api',
    ],
]);
