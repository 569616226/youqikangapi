<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            UpdateQuestionConfirmText
 *
 * @api                {PATCH} /v1/plan_depart_questions/:id/update_question_confirm_text 添加现场确认内容
 * @apiDescription     添加现场确认内容
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  confirm_text 现场确认内容 (富文本)
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('/plan_depart_questions/{id}/update_question_confirm_text', [
    'as'         => 'api_plan_depart_question_update_question_confirm_text',
    'uses'       => 'MobileController@updateQuestionConfirmText',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
