<?php

/**
 * @apiGroup           MobilePlanDepartQuestion
 * @apiName            findMobilePlanDepartQuestionById
 *
 * @api                {GET} /v1/plan_depart_questions/:id/mobile 微信部门问题详情
 * @apiDescription     微信部门问题详情
 *
 * @apiVersion         1.0.0
 * @apiPermission      登录用户
 *
 * @apiUse            MobilePlanDepartQuestionSuccessSingleResponse
 */

/** @var Route $router */
$router->get('plan_depart_questions/{id}/mobile', [
    'as'         => 'api_plan_depart_question_find_mobile_plan_depart_question_by_id',
    'uses'       => 'MobileController@findMobilePlanDepartQuestionById',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
