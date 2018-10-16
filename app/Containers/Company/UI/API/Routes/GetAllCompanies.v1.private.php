<?php

/**
 * @apiGroup           Company
 * @apiName            getAllCompanies
 *
 * @api                {GET} /v1/companies 客户管理
 * @apiDescription     客户列表
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
$router->get('companies', [
    'as'         => 'api_company_get_all_companies',
    'uses'       => 'Controller@getAllCompanies',
    'middleware' => [
        'auth:api',
    ],
]);
