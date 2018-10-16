<?php

/**
 * @apiGroup           MobileOrder
 * @apiName            findMobileOrderById
 *
 * @api                {GET} /v1/mobile/orders/:id 微信端订单详情
 * @apiDescription     微信端订单详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse            MobileOrderSuccessSingleResponse
 */

/** @var Route $router */
$router->get('/mobile/orders/{id}', [
    'as'         => 'api_order_find_mobile_order_by_id',
    'uses'       => 'MobileController@findMobileOrderById',
    'middleware' => [
        'auth:api',
    ],
]);
