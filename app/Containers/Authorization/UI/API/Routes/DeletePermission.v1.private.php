<?php

/**
 * @apiGroup           RolePermission
 * @apiName            deletePermission
 * @api                {delete} /v1/roles/:id 删除权限
 * @apiDescription     删除权限
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->delete('permissions/{id}', [
    'as'         => 'api_authorization_delete_permission',
    'uses'       => 'Controller@deletePermission',
    'middleware' => [
        'auth:api',
    ],
]);
