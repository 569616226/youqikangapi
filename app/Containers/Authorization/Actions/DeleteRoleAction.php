<?php

namespace App\Containers\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

/**
 * Class DeleteRoleAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteRoleAction extends Action
{

  /**
   * @param \App\Ship\Parents\Requests\Request $request
   *
   * @return  mixed
   */
  public function run(Request $request)
  {
    $role = Apiato::call('Authorization@FindRoleTask', [$request->id]);

    if ($role->name == 'admin' || $role->name == 'guest') {
      return error_simple_respone('不能删除超级管理员和客户联系人角色');
    }else{

      Apiato::call('Authorization@DeleteRoleTask', [$role]);

      if ($role) {
        return success_simple_respone($role->display_name . ' 角色删除成功');
      } else {
        return error_simple_respone();
      }
    }

  }
}
