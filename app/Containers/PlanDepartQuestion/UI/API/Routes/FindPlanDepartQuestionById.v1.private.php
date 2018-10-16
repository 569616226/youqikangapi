<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            findPlanDepartQuestionById
 *
 * @api                {GET} /v1/plan_depart_questions/:id 部门问题详情
 * @apiDescription     部门问题详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登录用户
 *
 * @apiUse            PlanDepartQuestionSuccessSingleResponse
 */

/** @var Route $router */
$router->get('plan_depart_questions/{id}', [
    'as'         => 'api_plan_depart_question_find_plan_depart_question_by_id',
    'uses'       => 'Controller@findPlanDepartQuestionById',
    'middleware' => [
        'auth:api',
    ],
]);
