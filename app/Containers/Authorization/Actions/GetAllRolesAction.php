<?php

namespace App\Containers\Authorization\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class GetAllRolesAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllRolesAction extends Action
{

  /**
   * @return  mixed
   */
  public function run()
  {

    /*只有超级管理员角色才能显示 admin guest 角色*/
    if (in_array('admin', \Auth::user()->roles->pluck('name')->toArray())) {

      $data = [
        'ordered'
      ];

    } else {

      $data = [
        'ordered',
        'no_admin_guest'
      ];

    }

    return Apiato::call('Authorization@GetAllRolesTask', [true], $data);

  }

}
