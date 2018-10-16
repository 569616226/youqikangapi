<?php

/**
 * @apiGroup           Users
 * @apiName            setAuditUser
 * @api                {put} /v1/users/:id/audit 设置负责人
 *                      设置负责人
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

$router->put('users/{id}/audit', [
    'as'         => 'api_user_set_audit_user',
    'uses'       => 'Controller@setAuditUser',
    'middleware' => [
        'auth:api',
    ],
]);
