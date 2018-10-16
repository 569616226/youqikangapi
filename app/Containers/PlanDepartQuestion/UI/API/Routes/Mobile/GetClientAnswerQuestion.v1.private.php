<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            getClientAnswerQuestion
 *
 * @api                {PATCH} /v1/plan_depart_questions/:id/client_answer_question 企业回答问题答案
 * @apiDescription     企业回答问题答案
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  client_answer 企业回答问题答案
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('plan_depart_questions/{id}/client_answer_question', [
    'as'         => 'api_plan_depart_question_client_answer_question',
    'uses'       => 'MobileController@getClientAnswerQuestion',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
