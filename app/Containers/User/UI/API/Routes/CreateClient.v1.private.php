<?php

/**
 * @apiGroup           Clients
 * @apiName            createClient
 * @api                {post} /v1/clients 创建客户联系人
 * @apiDescription     创建客户联系人
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  username 用户名
 * @apiParam           {String}  phone 手机号码
 * @apiParam           {Number}  role_id 角色id
 * @apiParam           {Number}  company_id 角色id
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->post('clients', [
    'as'         => 'api_user_create_client',
    'uses'       => 'Controller@createClient',
    'middleware' => [
        'auth:api',
    ],
]);
