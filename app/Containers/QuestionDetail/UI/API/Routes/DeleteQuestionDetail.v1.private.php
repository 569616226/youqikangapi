<?php

/**
 * @apiGroup           QuestionDetail
 * @apiName            deleteQuestionDetail
 *
 * @api                {DELETE} /v1/question_details/:id 删除进一步提问
 * @apiDescription     删除进一步提问
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiUse            GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->delete('question_details/{id}', [
    'as'         => 'api_question_detail_delete_question_detail',
    'uses'       => 'Controller@deleteQuestionDetail',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
