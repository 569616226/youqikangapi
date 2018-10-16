<?php

/**
 * @apiGroup           RolePermission
 * @apiName            deleteRole
 * @api                {delete} /v1/roles/:id 删除角色
 * @apiDescription     删除角色
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->delete('roles/{id}', [
    'as'         => 'api_authorization_delete_role',
    'uses'       => 'Controller@deleteRole',
    'middleware' => [
        'auth:api',
    ],
]);
