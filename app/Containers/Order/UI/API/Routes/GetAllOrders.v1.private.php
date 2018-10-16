<?php

/**
 * @apiGroup           Order
 * @apiName            getAllOrders
 *
 * @api                {GET} /v1/orders 订单列表
 * @apiDescription     订单列表
 *
 * @apiVersion         1.0.0
 * @apiPermission      登录用户
 *
 * @apiUse            OrderSuccessSingleResponse
 */

/** @var Route $router */
$router->get('orders', [
    'as'         => 'api_order_get_all_orders',
    'uses'       => 'Controller@getAllOrders',
    'middleware' => [
        'auth:api',
    ],
]);
