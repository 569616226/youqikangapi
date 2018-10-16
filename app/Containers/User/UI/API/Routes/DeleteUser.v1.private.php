<?php

/**
 * @apiGroup           Users
 * @apiName            deleteUser
 * @api                {delete} /v1/users/:id 删除用户 (管理员和客户联系人)
 * @apiDescription     删除用户 （所有用户）
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->delete('users/{id}', [
    'as'         => 'api_user_delete_user',
    'uses'       => 'Controller@deleteUser',
    'middleware' => [
        'auth:api',
    ],
]);
