<?php

namespace App\Containers\User\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class UpdateUserAction.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateUserAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {
        $userData = [
            'password'        => $request->password ? Hash::make($request->password) : null,
            'username'        => $request->username,
            'phone'           => $request->phone,
        ];

        return Apiato::call('User@UpdateUserTask', [$userData, $request->id, $request->role_id]);
    }
}
