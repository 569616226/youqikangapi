<?php

/**
 * @apiGroup           MobilePlanDepartQuestion
 * @apiName            getAllPlanDepartQuestions
 *
 * @api                {GET} /v1/plan_depart/:plan_depart_id/mobile/questions 微信部门问题列表
 * @apiDescription     微信部门问题列表
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *  "data":{
 *    [
 *      "object":"PlanDepartQuestion",
 *      "no_complate":"未完成",
 *      "auditing":"审核中",
 *      "success_audit":"已审核",
 *      "not_audit":"已驳回",
 *      "no_complate_count":"未完成数量",
 *      "success_audit_count":"已审核数量",
 *      "not_audit_count":"已驳回数量",
 *      "auditing_count":"审核中数量",
 *      "all_count":"所有数量",
 *      "is_finish":"是否完成",
 *
 *    ],
 *    "meta":{
 *      "include":[
 *      "stores",
 *      "invoices",
 *    ],
 *    "custom":[
 *
 *    ]
 *  }，
 * }
 */

/** @var Route $router */
$router->get('plan_depart/{id}/mobile/questions', [
    'as'         => 'api_plan_depart_question_get_all_mobile_plan_depart_questions',
    'uses'       => 'MobileController@getAllMobilePlanDepartQuestions',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
