<?php

/**
 * @apiGroup           Plan
 * @apiName            createPlan
 *
 * @api                {POST} /v1/plans 新建方案库
 * @apiDescription     新建方案库
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {Array}  plan_datas = [
 *  [
 * 'name'     => 'manager',
 * 'plan_departs' =>[
 * [
 * 'name' => 'depart_name' ,
 * 'iocn' => 'depart_icon' ,]
 *
 * ],
 *  'plan_depart_questions' => [
 * [ 'question' => 'question' ,
 * 'answers' => ['yes','no'] ,
 * ]
 * ]
 * ]
 * ]
 *
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('plans', [
    'as'         => 'api_plan_create_plan',
    'uses'       => 'Controller@createPlan',
    'middleware' => [
        'auth:api',
    ],
]);
