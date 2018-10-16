<?php

/**
 * @apiGroup           Clients
 * @apiName            getAllClients
 * @api                {get} /v1/clients 客户联系人列表
 * @apiDescription     客户列表
 *                     你可以通过邮箱，名字和id搜索客户，
 *                     例如: `?search=Mahmoud` or `?search=whatever@mail.com`.
 *                     你可以这样指定内容 `?search=email:whatever@mail.com` or `?search=id:20`.
 *                     你也可以这样指定多个值: `?search=name:Mahmoud&email:whatever@mail.com`.
 *
 * @apiVersion         1.0.0
 * @apiPermission     登陆用户
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

$router->get('clients', [
    'as'         => 'api_user_get_all_clients',
    'uses'       => 'Controller@getAllClients',
    'middleware' => [
        'auth:api',
    ],
]);
