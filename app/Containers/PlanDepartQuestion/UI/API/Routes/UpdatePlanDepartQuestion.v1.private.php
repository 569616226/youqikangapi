<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            updatePlanDepartQuestion
 *
 * @api                {PATCH} /v1/plan_depart_questions/:id 部门问题更新
 * @apiDescription     诊断方案部门问题更新
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('plan_depart_questions/{id}', [
    'as'         => 'api_plan_depart_question_update_plan_depart_question',
    'uses'       => 'Controller@updatePlanDepartQuestion',
    'middleware' => [
        'auth:api',
    ],
]);
