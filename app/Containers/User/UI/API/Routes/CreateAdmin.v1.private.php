<?php

/**
 * @apiGroup           Users
 * @apiName            createAdmin
 * @api                {post} /v1/admins 创建管理账号
 * @apiDescription     创建管理账号
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  password 密码
 * @apiParam           {String}  name 账号名
 * @apiParam           {String}  username 用户名
 * @apiParam           {String}  phone 手机号码
 * @apiParam           {Number}  role_id 角色id
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->post('admins', [
    'as'         => 'api_user_create_admin',
    'uses'       => 'Controller@createAdmin',
    'middleware' => [
        'auth:api',
    ],
]);
