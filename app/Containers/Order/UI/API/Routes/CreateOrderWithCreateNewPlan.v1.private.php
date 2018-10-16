<?php

/**
 * @apiGroup           Order
 * @apiName            creatPlanOrder
 *
 * @api                {POST} /v1/plan_orders 创建订单 (创建新的方案)
 * @apiDescription      创建订单
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆
 *
 * @apiParam           {String}  name 订单名称
 * @apiParam           {String}  status 是否开启项目 （'开启：进行中，不开启：未开始'）
 * @apiParam           {array}  plan_data 方案数据(和新建方案一样)
 * @apiParam           {Number}  company_id 客户id
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('plan_orders', [
    'as'         => 'api_order_create_order_with_create_new_plan',
    'uses'       => 'Controller@createOrderWithCreateNewPlan',
    'middleware' => [
        'auth:api',
    ],
]);
