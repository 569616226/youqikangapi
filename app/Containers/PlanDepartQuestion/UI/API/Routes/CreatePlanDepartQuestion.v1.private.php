<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            createPlanDepartQuestion
 *
 * @api                {POST} /v1/plan_depart_questions 新建部门问题
 * @apiDescription     新建部门问题
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  question 问题内容
 * @apiParam           {Array}  answers 问题答案
 * @apiParam           {Number}  plan_depart_id 诊断方案部门Id
 *
 * @apiUse             GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('plan_depart_questions', [
    'as'         => 'api_plan_depart_question_create_plan_depart_question',
    'uses'       => 'Controller@createPlanDepartQuestion',
    'middleware' => [
        'auth:api',
    ],
]);
