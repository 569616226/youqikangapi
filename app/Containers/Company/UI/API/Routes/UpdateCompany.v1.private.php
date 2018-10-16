<?php

/**
 * @apiGroup           Company
 * @apiName            updateCompany
 *
 * @api                {PATCH} /v1/companies/:id 编辑客户
 * @apiDescription     编辑客户
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
$router->patch('companies/{id}', [
    'as'         => 'api_company_update_company',
    'uses'       => 'Controller@updateCompany',
    'middleware' => [
        'auth:api',
    ],
]);
