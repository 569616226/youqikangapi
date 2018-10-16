<?php

namespace App\Containers\Wechat\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

/**
 * Class WelcomeApiRootVisitorAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteWechatMenuAction extends Action
{

    /**
     * @return  array
     */
    public function run(Request $request)
    {
        return Apiato::call('Wechat@DeleteWechatMenuTask', [$request->id]);
    }
}
