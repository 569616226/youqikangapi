<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            DelQuestionMoreFiles
 *
 * @api                {POST} /v1/plan_depart_questions/:id/del_question_more_files  删除补充材料图片
 * @apiDescription      补充材料
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {Number}  image_url_index 补充材料图片url 数组key
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->post('plan_depart_questions/{id}/del_question_more_files', [
    'as'         => 'api_plan_depart_question_del_question_more_files',
    'uses'       => 'MobileController@delQuestionMoreFiles',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
