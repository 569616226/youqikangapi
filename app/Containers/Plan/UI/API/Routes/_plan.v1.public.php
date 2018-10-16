<?php

/**
 * @apiDefine PlanSuccessSingleResponse
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "object":"Plan",
 * "id":eqwja3vw94kzmxr0,
 * "name":"方案名称",
 * "is_parent":"是否是标准库",
 * "eidter":"编辑人/创建人",
 * "plan_depart_counts":"部门数",
 * "plan_depart_question_counts":"问题数",
 * "created_at":"2017-06-06 05:40:51,
 * "updated_at":2017-06-06 05:40:51,
 * "plan_departs":[
 *  "data":{
 *    [
 *      "object":"PlanDepart",
 *      "name":"部门名称",
 *      "icon":"部门图标",
 *      "created_at":"2017-06-06 05:40:51,
 *      "updated_at":2017-06-06 05:40:51,
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
 * ],
 * "meta":{
 * "include":[
 * "stores",
 * "invoices",
 * ],
 * "custom":[
 *
 * ]
 * }
 * }
 */

