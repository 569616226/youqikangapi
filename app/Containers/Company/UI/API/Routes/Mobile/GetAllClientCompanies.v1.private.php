<?php

/**
 * @apiGroup           MobileCompany
 * @apiName            getAllClientCompanies
 *
 * @api                {GET} /v1/client_companies 微信端企业列表 （查看报告）
 * @apiDescription     微信端企业列表
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
 * "created_at":"创建时间",
 * }
 */

/** @var Route $router */
$router->get('/client_companies', [
    'as'         => 'api_company_get_client_all_companies',
    'uses'       => 'MobileController@getAllClientCompanies',
    'middleware' => [
        'auth:api',
    ],
])->middleware('client');
