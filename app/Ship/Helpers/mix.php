<?php

if (!function_exists('success_simple_respone')) {

  /*
   * 成功操作返回体
   * @param string msg
   * @return Response json
   * */
  function success_simple_respone($msg = '操作成功')
  {
    return response()->json(['status' => true, 'msg' => $msg]);
  }
}

if (!function_exists('error_simple_respone')) {

  /*
   * 失败操作返回体
   * @param string msg
   * @return Response json
   * */
  function error_simple_respone($msg = '操作失败')
  {
    return response()->json(['status' => false, 'msg' => $msg]);
  }
}

if (!function_exists('create_order_number')) {

  /*
   *
   *  订单号
   * @return string $order_mumber
   * */
  function create_order_number($order_str = 'YQK')
  {
    $order_number = $order_str;

    $order_number .= now()->timestamp;

    return $order_number;
  }
}


if (!function_exists('is_del_plan')) {

  /*
   * 判断能不能删除方案
   *
   * @return Plan $plan | String
   * */
   function is_del_plan($plan)
  {

    if (optional($plan->order)->status == '已完成') {

      return '该方案的订单已经完成,不能编辑删除方案内容';

    } else {

      return $plan;
    }
  }

}

