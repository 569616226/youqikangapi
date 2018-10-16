<?php

/**
 * @apiGroup           Order
 * @apiName            refrozenOrder
 *
 * @api                {GET} /v1/orders/:id/refrozen 解冻订单
 * @apiDescription     解冻订单
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->GET('orders/{id}/refrozen', [
    'as'         => 'api_order_refrozen_order',
    'uses'       => 'Controller@refrozenOrder',
    'middleware' => [
        'auth:api',
    ],
]);
