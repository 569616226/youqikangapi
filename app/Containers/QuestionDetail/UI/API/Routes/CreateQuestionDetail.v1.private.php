<?php

/**
 * @apiGroup           QuestionDetail
 * @apiName            createQuestionDetail
 *
 * @api                {POST} /v1/question_details 添加进一步提问
 * @apiDescription     添加进一步提问
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {Number}  plan_depart_question_id 问题id
 * @apiParam           {String}  question 提问内容
 * @apiParam           {String}  answer 问题回答内容(支持富文本)
 *
 * @apiUse            GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('question_details', [
    'as'         => 'api_question_detail_create_question_detail',
    'uses'       => 'Controller@createQuestionDetail',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
