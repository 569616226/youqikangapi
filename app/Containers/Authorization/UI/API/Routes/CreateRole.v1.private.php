<?php

/**
 * @apiGroup           RolePermission
 * @apiName            createRole
 * @api                {post} /v1/roles 新建角色
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String} name 角色唯一名字
 * @apiParam           {String} [description] 角色描述
 * @apiParam           {String} [display_name] 角色显示名字
 * @apiParam           {Array} permissions_ids 权限id 和 权限id数组
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->post('roles', [
    'as'         => 'api_authorization_create_role',
    'uses'       => 'Controller@createRole',
    'middleware' => [
        'auth:api',
    ],
]);
