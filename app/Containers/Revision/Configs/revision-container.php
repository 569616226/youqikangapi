<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Revision Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    /*系统模块*/
    'revisionable_type' => [
        'App\\Containers\\Authorization\\Models\\Role'                    => '角色管理',
        'App\\Containers\\Authorization\\Models\\Permission'              => '权限管理',
        'App\\Containers\\User\\Models\\User'                             => '账号管理',
        'App\\Containers\\User\\Models\\Setting'                          => '公众号管理',
        'App\\Containers\\Company\\Models\\Company'                       => '客户管理',
        'App\\Containers\\Order\\Models\\Order'                           => '订单管理',
        'App\\Containers\\Plan\\Models\\Plan'                             => '诊断标准管理',
        'App\\Containers\\PlanDepart\\Models\\PlanDepart'                 => '诊断标准管理-部门',
        'App\\Containers\\PlanDepartQuestion\\Models\\PlanDepartQuestion' => '诊断标准管理-部门问题',
        'App\\Containers\\QuestionDetail\\Models\\QuestionDetail'         => '诊断标准管理-部门问题',
        'App\\Containers\\Report\\Models\\Report'                         => '报告',
        'App\\Containers\\Invitation\\Models\\Invitation'                 => '报告授权',
        'App\\Containers\\Message\\Models\\Message'                       => '微信消息',
    ],

    /*操作类型*/
    'key'               => [
        'created_at' => '新建',
        'deleted_at' => '删除',
        'is_frozen'  => '冻结/解冻',
        'login'      => '登陆',
    ],

];
