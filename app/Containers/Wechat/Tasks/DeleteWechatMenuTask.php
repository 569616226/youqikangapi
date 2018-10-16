<?php

namespace App\Containers\Wechat\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Illuminate\Http\Request;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteWechatMenuTask extends Action
{

    /**
     * @return  array
     */
    public function run($id)
    {
        $officialAccount = \EasyWeChat::officialAccount();
        if ($id) {
            $officialAccount->menu->delete($id);
        } else {
            $officialAccount->menu->delete(); // 全部
        }
    }
}
