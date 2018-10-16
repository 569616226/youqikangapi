<?php

/**
 * @apiGroup           Order
 * @apiName            startOrder
 *
 * @api                {PATCH} /v1/orders/:id/start 启动订单
 * @apiDescription     启动订单
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('orders/{id}/start', [
    'as'         => 'api_order_start_order',
    'uses'       => 'Controller@startOrder',
    'middleware' => [
        'auth:api',
    ],
]);
