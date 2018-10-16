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
class UpdateUserPasswordAction extends Action
{

    /**
     * @param \App\Ship\Parents\Requests\Request $request
     *
     * @return  mixed
     */
    public function run(Request $request)
    {
        $userData = [
            'password' => $request->password ? Hash::make($request->password) : null,
        ];

        // remove null values and their keys
        $userData = array_filter($userData);

        return Apiato::call('User@UpdateUserPasswordTask', [$userData, $request->id]);
    }
}
