<?php

/**
 * @apiGroup           RolePermission
 * @apiName            createPermission
 * @api                {post} /v1/permissions 新建角色
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String} name 权限唯一名字
 * @apiParam           {String} [description] 权限描述
 * @apiParam           {String} [display_name] 权限显示名字
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->post('permissions', [
    'as'         => 'api_authorization_create_permission',
    'uses'       => 'Controller@createPermission',
    'middleware' => [
        'auth:api',
    ],
]);
