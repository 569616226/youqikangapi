<?php

/**
 * @apiGroup           Clients
 * @apiName            updateClient
 * @api                {put} /v1/clients/:id 编辑客户联系人
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  username 用户名
 * @apiParam           {String}  phone 手机
 * @apiParam           {Number}  role_id 角色id
 * @apiParam           {Number}  company_id 角色id
 * @apiParam           {Number}   is_client_admin 企业主
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->put('clients/{id}', [
    'as'         => 'api_user_update_clinet',
    'uses'       => 'Controller@updateClient',
    'middleware' => [
        'auth:api',
    ],
]);
