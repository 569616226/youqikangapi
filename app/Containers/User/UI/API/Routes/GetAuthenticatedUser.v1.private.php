<?php

/**
 * @apiGroup           Users
 * @apiName            getAuthenticatedUser
 *
 * @api                {GET} /v1/user/profile 登陆用户信息
 * @apiDescription     登陆用户信息
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             UserSuccessSingleResponse
 */

$router->get('user/profile', [
    'as'         => 'api_user_get_authenticated_user',
    'uses'       => 'Controller@getAuthenticatedUser',
    'middleware' => [
        'auth:api',
    ],
]);
