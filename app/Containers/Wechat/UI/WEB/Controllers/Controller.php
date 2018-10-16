<?php

namespace App\Containers\Wechat\UI\WEB\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Http\Request;

/**
 * Class Controller.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class Controller extends WebController
{

  /*
   * 设置客户联系人菜单
   *
   *
   * */
  public function setWechatClientMenu()
  {

    return Apiato::call('Wechat@SetWechatClientMenuAction');

  }

  /*
   * 设置菜单
   *
   *
   * */
  public function setWechatUserMenu()
  {

    return Apiato::call('Wechat@SetWechatUserMenuAction');

  }

  /*
   * 设置菜单
   *
   *
   * */
  public function setWechatMenu()
  {

    return Apiato::call('Wechat@SetWechatMenuAction');

  }

  /*
    * 菜单列表
    *
    *
    * */
  public function getWechatMenus()
  {
    return Apiato::call('Wechat@GetWechatMenusAction');

  }


  /*
   * 删除菜单
   *
   *
   * */
  public function deleteWechatMenu(Request $request)
  {
    return Apiato::call('Wechat@DeleteWechatMenuAction', [$request]);

  }

  /**
   * @return  \Illuminate\Http\JsonResponse
   */
  public function wechatServe()
  {

    $wechat = Apiato::call('Wechat@WechatServeAction');

    return $wechat;

  }

}
