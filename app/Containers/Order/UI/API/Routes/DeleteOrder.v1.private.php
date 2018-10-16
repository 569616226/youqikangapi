<?php

/**
 * @apiGroup           Order
 * @apiName            deleteOrder
 *
 * @api                {DELETE} /v1/orders/:id 删除订单 （只能删除未开始的）
 * @apiDescription     删除订单 （只能删除未开始的）
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->delete('orders/{id}', [
    'as'         => 'api_order_delete_order',
    'uses'       => 'Controller@deleteOrder',
    'middleware' => [
        'auth:api',
    ],
]);
