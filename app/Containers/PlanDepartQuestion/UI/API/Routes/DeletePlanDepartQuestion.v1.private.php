<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            deletePlanDepartQuestion
 *
 * @api                {DELETE} /v1/plan_depart_questions/:id 删除部门问题
 * @apiDescription     删除部门问题
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->delete('plan_depart_questions/{id}', [
    'as'         => 'api_plan_depart_question_delete_plan_depart_question',
    'uses'       => 'Controller@deletePlanDepartQuestion',
    'middleware' => [
        'auth:api',
    ],
]);
