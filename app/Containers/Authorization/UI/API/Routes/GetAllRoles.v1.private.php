<?php

/**
 * @apiGroup           RolePermission
 * @apiName            getAllRoles
 * @api                {get} /v1/roles 角色列表
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

$router->get('roles', [
    'as'         => 'api_authorization_get_all_roles',
    'uses'       => 'Controller@getAllRoles',
    'middleware' => [
        'auth:api',
    ],
]);
