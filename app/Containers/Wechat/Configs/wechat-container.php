<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Welcome Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    'temp_id' => env('QCLOUDSMS_TEMPLID', 169579),
    'app_id'  => env('QCLOUDSMS_APPID', 1400120136),
    'app_key' => env('QCLOUDSMS_APPKEY', '7dd2a90e112b01b50761edec2fee81c9'),

    'wechat_send_msg_temp_id' => env('WECHAT_SEND_MSG_TEMP_ID', 'NMCx77VBRYGcF4eLS9LqEMXTR_jnfHxOw5Mb8mcl7eQ'),//邀请人微信模块消息
    'wechat_msg_temp_id'      => env('WECHAT_MSG_TEMP_ID', 'XZ1LF9ui1hbdRig9edy3f8UUD_3gSeRpgd60fmBTN7M'),//绑定人微信模块消息

    'test_sms_code'      => env('TEST_SMS_CODE', 111111),//测试用的短信码
];
