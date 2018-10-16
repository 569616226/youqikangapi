<?php

/**
 * @apiGroup           RolePermission
 * @apiName            getRole
 * @api                {get} /v1/roles/:id 角色详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             RoleSuccessSingleResponse
 */

$router->get('roles/{id}', [
    'as'         => 'api_authorization_get_role',
    'uses'       => 'Controller@findRole',
    'middleware' => [
        'auth:api',
    ],
]);
