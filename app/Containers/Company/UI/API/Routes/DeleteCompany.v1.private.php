<?php

/**
 * @apiGroup           Company
 * @apiName            deleteCompany
 *
 * @api                {DELETE} /v1/companies/:id 删除客户
 * @apiDescription     删除客户
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->delete('companies/{id}', [
    'as'         => 'api_company_delete_company',
    'uses'       => 'Controller@deleteCompany',
    'middleware' => [
        'auth:api',
    ],
]);
