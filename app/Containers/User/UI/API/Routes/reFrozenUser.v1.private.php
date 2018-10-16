<?php

/**
 * @apiGroup           Users
 * @apiName            refrozenUser
 * @api                {put} /v1/users/:id/refrozen 解冻用户 （管理员和客户联系人）
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->put('users/{id}/refrozen', [
    'as'         => 'api_user_refrzoen_user',
    'uses'       => 'Controller@refrozenUser',
    'middleware' => [
        'auth:api',
    ],
]);
