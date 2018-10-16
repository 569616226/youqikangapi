<?php

/**
 * @apiGroup           Revision
 * @apiName            getAllRevisions
 *
 * @api                {GET} /v1/revisions 系统日志
 * @apiDescription     系统日志
 *
 * @apiVersion         1.0.0
 * @apiPermission      用户登录
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "object":"Revision",
 * "id":eqwja3vw94kzmxr0,
 * "user_name":"用户名",
 * "revisionable_type":"所属模块",
 * "key":"操作类型",
 * "value":"日志内容
 * "created_at":"2017-06-06 05:40:51,
 * "updated_at":2017-06-06 05:40:51,
 *
 * "meta":{
 * "include":[
 * "stores",
 * "invoices",
 * ],
 * "custom":[
 *
 * ]
 * }
 * }
 */

/** @var Route $router */
$router->get('revisions', [
    'as'         => 'api_revision_get_all_revisions',
    'uses'       => 'Controller@getAllRevisions',
    'middleware' => [
        'auth:api',
    ],
]);
