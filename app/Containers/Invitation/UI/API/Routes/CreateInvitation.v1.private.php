<?php

/**
 * @apiGroup           Report
 * @apiName            createInvitation
 *
 * @api                {POST} /v1/reports/{id}/invitations 报告分享授权
 * @apiDescription    报告分享授权
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {Array}  depart_ids 授权报告部门id
 */

/** @var Route $router */
$router->post('reports/{id}/invitations', [
    'as'         => 'api_invitation_create_invitation',
    'uses'       => 'Controller@createInvitation',
    'middleware' => [
        'auth:api',
    ],
]);
