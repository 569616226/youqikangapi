<?php

return [

   /*项目公用设置*/

    'skip_test' => env('SKIP_TEST', true),
    'send_report_event' => env('SEND_REPORT_EVENT', true),
    'send_audit_user_event' => env('SEND_AUDIT_USER_EVENT', true),
    'send_frozen_user_event' => env('SEND_FROZEN_USER_EVENT', true),
    'send_set_client_admin_user_event' => env('SEND_SET_CLIENT_ADMIN_USER_EVENT', true),



];
