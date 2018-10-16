<?php

/**
 * @apiGroup           RolePermission
 * @apiName            syncPermissionOnRole
 * @api                {post} /v1/permissions/sync 同步角色权限
 * @apiDescription     你可以用 `permissions/attach` 和 `permissions/detach`替代.
 *                     这个接口将会用新的权限替换用户原有的所有权限.
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {Number} role_id 角色id
 * @apiParam           {Array} permissions_ids 权限id 和 权限id数组
 * @apiParam           {String} name 角色唯一名字
 * @apiParam           {String} [display_name] 角色显示名字
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->post('permissions/sync', [
    'as'         => 'api_authorization_sync_permission_on_role',
    'uses'       => 'Controller@syncPermissionOnRole',
    'middleware' => [
        'auth:api',
    ],
]);
