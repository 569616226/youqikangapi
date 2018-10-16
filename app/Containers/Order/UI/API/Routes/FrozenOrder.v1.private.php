<?php

/**
 * @apiGroup           Order
 * @apiName            frozenOrder
 *
 * @api                {GET} /v1/orders/:id/frozen 冻结订单
 * @apiDescription     冻结订单
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->GET('orders/{id}/frozen', [
    'as'         => 'api_order_frozen_order',
    'uses'       => 'Controller@frozenOrder',
    'middleware' => [
        'auth:api',
    ],
]);
