<?php

/**
 * @apiGroup           Users
 * @apiName            updateUser
 * @api                {put} /v1/users/:id 编辑用户 （管理员和客户联系人）
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  password 密码
 * @apiParam           {String}  name 账号名
 * @apiParam           {String}  username 用户名
 * @apiParam           {String}  phone 手机
 * @apiParam           {Number}  role_id 角色id
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->put('users/{id}', [
    'as'         => 'api_user_update_user',
    'uses'       => 'Controller@updateUser',
    'middleware' => [
        'auth:api',
    ],
]);
