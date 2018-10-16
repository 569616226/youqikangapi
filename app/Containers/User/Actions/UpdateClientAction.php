<?php

namespace App\Containers\User\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

/**
 * Class UpdateUserAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateClientAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {
        $userData = [
            'username' => $request->username,
            'phone'    => $request->phone,
            'is_client_admin' => $request->is_client_admin,
        ];

        return Apiato::call('User@UpdateClientTask', [$userData, $request->id, $request->company_id]);
    }
}
