<?php

/**
 * @apiGroup           PlanDepartQuestion
 * @apiName            AuditQuestion
 *
 * @api                {PATCH} /v1/plan_depart_questions/:id/audit_question 审核问题
 * @apiDescription     审核问题
 *
 * @apiVersion         1.0.0
 * @apiPermission      登陆用户
 *
 * @apiParam           {String}  status 审核状态
 * @apiParam           {String}  audit_text 审核备注
 *
 * @apiUse              GeneralSuccessedOrFailedResponse
 */

/** @var Route $router */
$router->patch('plan_depart_questions/{id}/audit_question', [
    'as'         => 'api_plan_depart_question_audit_question',
    'uses'       => 'MobileController@auditQuestion',
    'middleware' => [
        'auth:api',
    ],
])->middleware('user');
