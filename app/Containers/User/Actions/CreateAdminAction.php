<?php

namespace App\Containers\User\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

/**
 * Class CreateAdminAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateAdminAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {
        $admin = Apiato::call('User@CreateUserByCredentialsTask', [
            $isClient = false,
            $request->password,
            $request->name,
            $request->phone,
            $request->username,
            $request->role_id
        ]);

        return $admin;
    }
}
