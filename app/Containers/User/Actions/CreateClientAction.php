<?php

namespace App\Containers\User\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authorization\Models\Role;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

/**
 * Class CreateAdminAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateClientAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {

        $user = Apiato::call('User@CreateClientByCredentialsTask', [
            $isClient = true,
            $request->phone,
            $request->username,
            $request->phone,
            $request->username,
            $request->company_id,
            $request->is_client_admin
        ]);

        return $user;
    }
}
