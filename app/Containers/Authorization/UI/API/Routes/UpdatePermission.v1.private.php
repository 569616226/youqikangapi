<?php

/**
 * @apiGroup           RolePermission
 * @apiName            updatePermission
 * @api                {put} /v1/permissions/:id 编辑权限
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆权限
 *
 * @apiParam           {String} name 权限唯一名字
 * @apiParam           {String} [description] 权限描述
 * @apiParam           {String} [display_name] 权限显示名字
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->put('permissions/{id}', [
    'as'         => 'api_authorization_update_permission',
    'uses'       => 'Controller@updatePermission',
    'middleware' => [
        'auth:api',
    ],
]);
