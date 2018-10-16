<?php

/**
 * @apiGroup           Users
 * @apiName            updateUserPassword
 * @api                {put} /v1/users/:id/password 修改密码 （管理员和客户联系人）
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  password 密码
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->put('users/{id}/password', [
    'as'         => 'api_user_update_user_password',
    'uses'       => 'Controller@updateUserPassword',
    'middleware' => [
        'auth:api',
    ],
]);
