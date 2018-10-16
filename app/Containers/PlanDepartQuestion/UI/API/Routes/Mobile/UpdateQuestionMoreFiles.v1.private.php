<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            UpdateQuestionMoreFiles
 *
 * @api                {PATCH} /v1/plan_depart_questions/:id/update_question_more_files  上传补充材料
 * @apiDescription      上传补充材料
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {Array}  more_file 补充材料图片url
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('plan_depart_questions/{id}/update_question_more_files', [
    'as'         => 'api_plan_depart_question_update_question_more_files',
    'uses'       => 'MobileController@updateQuestionMoreFiles',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
