<?php

/**
 * @apiGroup           Order
 * @apiName            updateOrder
 *
 * @api                {PATCH} /v1/orders/:id 更新订单
 * @apiDescription     更新订单
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  name 订单名称
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('orders/{id}', [
    'as'         => 'api_order_update_order',
    'uses'       => 'Controller@updateOrder',
    'middleware' => [
        'auth:api',
    ],
]);
