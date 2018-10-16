<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            UpdateQuestionConclusionText
 *
 * @api                {PATCH} /v1/plan_depart_questions/:id/update_question_conclusion_text 添加最终结论内容
 * @apiDescription     添加最终结论内容
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  conclusion_text 添加最终结论内容 (富文本)
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('/plan_depart_questions/{id}/update_question_conclusion_text', [
    'as'         => 'api_plan_depart_question_update_question_conclusion_text',
    'uses'       => 'MobileController@updateQuestionConclusionText',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
