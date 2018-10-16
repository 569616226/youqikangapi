<?php

/**
 * @apiGroup           RolePermission
 * @apiName            getAllPermissions
 * @api                {get} /v1/permissions 权限列表
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

$router->get('permissions', [
    'as'         => 'api_authorization_get_all_permissions',
    'uses'       => 'Controller@getAllPermissions',
    'middleware' => [
        'auth:api',
    ],
]);
