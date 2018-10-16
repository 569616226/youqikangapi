<?php

/**
 * @apiGroup           Order
 * @apiName            createOrder
 *
 * @api                {POST} /v1/orders 创建订单
 * @apiDescription      创建订单
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆
 *
 * @apiParam           {String}  name 订单名称
 * @apiParam           {String}  status 是否开启项目 （'开启：进行中，不开启：未开始'）
 * @apiParam           {Number}  plan_id 方案id
 * @apiParam           {Number}  company_id 客户id
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('orders', [
    'as'         => 'api_order_create_order',
    'uses'       => 'Controller@createOrder',
    'middleware' => [
        'auth:api',
    ],
]);
