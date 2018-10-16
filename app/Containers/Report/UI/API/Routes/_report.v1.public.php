<?php

/**
 * @apiDefine ReportSuccessSingleResponse
 * @apiSuccessExample {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data":{
 * "object":"Report",
 * "id":eqwja3vw94kzmxr0,
 * "name":"订单名称",
 * "created_at":"2017-06-06 05:40:51,
 * "updated_at":2017-06-06 05:40:51,
 * "report_departs":[
 *      "data" : {
 *      "object":"ReportDepart",
 *      "id":eqwja3vw94kzmxr0,
 *      "name" : "部门名称"
 *      "company_logo" : "公司logo"
 *      "icon" : "部门图标"
 *      "counts" : "部门所有问题总数量"
 *      "nomarl_counts" : "部门合格问题总数量"
 *      "error_counts" : "部门错误问题总数量"
 *      "general_counts" : "部门一般问题总数量"
 *      "middle_counts" : "部门中等问题总数量"
 *      "hight_counts" : "部门偏高问题总数量"
 *      "serious_counts" : "部门严重问题总数量"
 *      "nomarl_rate" : "部门合格问题占总问题比例"
 *      "general_rate" : "部门一般问占总问题比例"
 *      "middle_rate" : "部门中等问题占总问题比例"
 *      "hight_rate" : "部门偏高问题占总问题比例"
 *      "serious_rate" : "部门严重问题占总问题比例"
 *      "type" : "部门严重问题占总问题比例"
 *      "nomarl_questions" : "部门合格问题"
 *      "general_questions" : "部门一般问"
 *      "middle_questions" : "部门中等问题"
 *      "hight_questions" : "部门偏高问题"
 *      "serious_questions" : "部门严重问题"
 *      "created_at" : "报告生产时间"
 *     }
 *
 *    ],
 * "meta":{
 * "include":[
 * "stores",
 * "invoices",
 * ],
 * "custom":[
 *
 *  ]
 *  }
 * }
 */

