<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            getAllPlanDepartQuestions
 *
 * @api                {GET} /v1/plan_depart/:plan_depart_id/questions 部门问题列表
 * @apiDescription     诊断方案部门问题列表
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse            PlanDepartQuestionSuccessSingleResponse
 */

/** @var Route $router */
$router->get('plan_depart/{id}/questions', [
    'as'         => 'api_plan_depart_question_get_all_plan_depart_questions',
    'uses'       => 'Controller@getAllPlanDepartQuestions',
    'middleware' => [
        'auth:api',
    ],
]);
