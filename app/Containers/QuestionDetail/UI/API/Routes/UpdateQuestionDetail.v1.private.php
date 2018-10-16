<?php

/**
 * @apiGroup           QuestionDetail
 * @apiName            updateQuestionDetail
 *
 * @api                {PATCH} /v1/question_details/:id 进一步提问编辑
 * @apiDescription     进一步提问编辑
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  question 提问内容
 * @apiParam           {String}  answer 问题回答内容(支持富文本)
 *
 * @apiUse            GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('question_details/{id}', [
    'as'         => 'api_question_detail_update_question_detail',
    'uses'       => 'Controller@updateQuestionDetail',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
