<?php

namespace App\Containers\Wechat\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetWechatMenusTask extends Action
{

    /**
     * @return  array
     */
    public function run()
    {
        $officialAccount = \EasyWeChat::officialAccount();

        $current_menus = $officialAccount->menu->current();
        $menus = $officialAccount->menu->list();

        return ['current' => $current_menus, 'menus' => $menus];
    }
}
