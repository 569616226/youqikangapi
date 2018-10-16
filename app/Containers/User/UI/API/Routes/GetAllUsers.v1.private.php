<?php

/**
 * @apiGroup           Users
 * @apiName            getAllUsers
 * @api                {get} /v1/users 所有用户列表
 * @apiDescription     获取所有用户 (客户 and 管理员). 获取所有用户你可以用 `/clients`. 获取所有管理员 `/admins`.
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

$router->get('users', [
    'as'         => 'api_user_get_all_users',
    'uses'       => 'Controller@getAllUsers',
    'middleware' => [
        'auth:api',
    ],
]);
