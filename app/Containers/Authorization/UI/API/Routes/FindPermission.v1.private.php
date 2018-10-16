<?php

/**
 * @apiGroup           RolePermission
 * @apiName            getPermission
 * @api                {get} /v1/permissions/:id 权限详情
 *
 * @apiVersion         1.0.0
 * @apiPermission     登陆用户
 *
 * @apiUse             PermissionSuccessSingleResponse
 */

$router->get('permissions/{id}', [
    'as'         => 'api_authorization_get_permission',
    'uses'       => 'Controller@findPermission',
    'middleware' => [
        'auth:api',
    ],
]);
