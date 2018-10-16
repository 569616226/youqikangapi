<?php

/**
 * @apiGroup           Users
 * @apiName            findUserById
 * @api                {get} /v1/users/:id 用户详情 （管理员和客户联系人）
 * @apiDescription     用户详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             UserSuccessSingleResponse
 */

$router->get('users/{id}', [
    'as'         => 'api_user_find_user',
    'uses'       => 'Controller@findUserById',
    'middleware' => [
        'auth:api',
    ],
]);
