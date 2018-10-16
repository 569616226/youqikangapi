<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            AuditMoreQuestion
 *
 * @api                {PATCH} /v1/plan_depart_questions/audit_more_question 批量审核问题
 * @apiDescription     批量审核问题
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  status 审核状态
 * @apiParam           {Array}  question_ids 问题id array
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('plan_depart_questions/audit_more_question', [
    'as'         => 'api_plan_depart_question_audit_more_question',
    'uses'       => 'MobileController@auditMoreQuestion',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
