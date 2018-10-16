<?php

/**
 * @apiGroup           Users
 * @apiName            frozenUser
 * @api                {put} /v1/users/:id/frozen 冻结用户 （管理员和客户联系人）
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->put('users/{id}/frozen', [
    'as'         => 'api_user_frzoen_user',
    'uses'       => 'Controller@frozenUser',
    'middleware' => [
        'auth:api',
    ],
]);
