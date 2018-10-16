<?php

/**
 * @apiGroup           Company
 * @apiName            createCompany
 *
 * @api                {POST} /v1/companies 新建客户
 * @apiDescription     新建客户
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  name 客户名称
 * @apiParam           {String}  [logo] 客户logo
 * @apiParam           {Array}  user_ids 客户联系人id数组
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('companies', [
    'as'         => 'api_company_create_company',
    'uses'       => 'Controller@createCompany',
    'middleware' => [
        'auth:api',
    ],
]);
