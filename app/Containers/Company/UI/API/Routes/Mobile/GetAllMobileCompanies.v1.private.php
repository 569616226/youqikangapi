<?php

/**
 * @apiGroup           MobileCompany
 * @apiName            getAllMobileCompanies
 *
 * @api                {GET} /v1/mobile_companies 微信端企业列表 （提交数据）
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
$router->get('/mobile_companies', [
    'as'         => 'api_company_get_mobile_all_companies',
    'uses'       => 'MobileController@getAllMobileCompanies',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
