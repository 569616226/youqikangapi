<?php

/**
 * @apiDefine MobileOrderSuccessSingleResponse
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "object":"Order",
 * "id":eqwja3vw94kzmxr0,
 * "name":"订单名称",
 * "status":"订单状态",
 * "start_at":"启动时间",
 * "plan_departs":[
 *    "name":"部门名称"，
 *    "icon":"部门图标"，
 *    "is_finish":"部门是否完成"，
 *    "auditings":"审核中的问题数量"，
 *    "all_counts":"问题总数"，
 *    "complates":"完成问题数量"，
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

