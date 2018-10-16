<?php

/**
 * @apiGroup           Company
 * @apiName            findCompanyById
 *
 * @api                {GET} /v1/companies/:id 客户详情
 * @apiDescription     客户详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "object":"Company",
 * "id":eqwja3vw94kzmxr0,
 * "name":"客户名字",
 * "logo":"客户logo",
 * "creator":"创建人",
 * "created_at":"创建时间",
 * "updated_at":"更新时间",
 * "uesrs":['客户联系人'],
 * }
 */

/** @var Route $router */
$router->get('companies/{id}', [
    'as'         => 'api_company_find_company_by_id',
    'uses'       => 'Controller@findCompanyById',
    'middleware' => [
        'auth:api',
    ],
]);
