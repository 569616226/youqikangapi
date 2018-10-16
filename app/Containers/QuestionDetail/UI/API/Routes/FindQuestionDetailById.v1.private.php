<?php

/**
 * @apiGroup           QuestionDetail
 * @apiName            findQuestionDetailById
 *
 * @api                {GET} /v1/question_details/:id 进一步问题详情
 * @apiDescription     进一步问题详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiUse              QuestionDetailSuccessSingleResponse
 */

/** @var Route $router */
$router->get('question_details/{id}', [
    'as'         => 'api_question_detail_find_question_detail_by_id',
    'uses'       => 'Controller@findQuestionDetailById',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
