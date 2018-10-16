<?php

namespace App\Containers\Wechat\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class WechatServeAction extends Action
{

    /**
     * @return  array
     */
    public function run()
    {
        return Apiato::call('Wechat@WechatServeTask');
    }
}
