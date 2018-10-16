<?php


/**
 * @apiGroup           Home
 * @apiName            homePage
 *
 * @api                {GET} /v1/ 首页
 * @apiDescription      创建订单
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "orders":"订单数",
 * "clients":"客户联系人数",
 * "companies":“客户数”,
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

// API Root route
$router->get('/', [
    'as'         => 'api_home_root_page',
    'uses'       => 'Controller@homePage',
    'middleware' => [
        'auth:api',
    ],
]);
