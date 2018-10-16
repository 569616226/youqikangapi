<?php

/**
 * @apiGroup           Clients
 * @apiName            findClinetById
 * @api                {get} /v1/clients/:id 客户联系人详情
 * @apiDescription     客户联系人详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             UserSuccessSingleResponse
 */

$router->get('clients/{id}', [
    'as'         => 'api_user_find_clinet',
    'uses'       => 'Controller@findClientById',
    'middleware' => [
        'auth:api',
    ],
]);
