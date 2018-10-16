<?php

/**
 * @apiDefine MobilePlanDepartQuestionSuccessSingleResponse
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *  "data":{
 *    [
 *      "object":"PlanDepartQuestion",
 *      "name":"问题内容",
 *      "status":"问题状态",
 *      "client_answer":"客户回答",
 *      "more_files":"补充材料",
 *      "confirm_text":"现场确认内容",
 *      "confirm_at":"现场确认编辑时间",
 *      "conclusion_status":"最终结论 严重性",
 *      "conclusion_at":"最终结论编辑时间",
 *      "conclusion":"最终结论内容",
 *      "plan_depart":"所属部门",
 *      "conclusion_editer":"最终结论执行人",
 *      "confirm_editer":"现场确认执行人",
 *      "client_answer_editer":"调查过程执行人",
 *      "auditer":"问题审核人",
 *      "audit_text":"审核备注",
 *      "audit_at":"审核时间",
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

