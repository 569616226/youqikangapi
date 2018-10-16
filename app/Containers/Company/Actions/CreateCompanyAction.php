<?php

namespace App\Containers\Company\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CreateCompanyAction extends Action
{
    public function run(Request $request)
    {
        $data = [
            'name'    => $request->name,
            'logo'    => $request->logo ?? config('company-container.default_logo_url'),
            'creator' => Auth::user()->username,
        ];

        $company = Apiato::call('Company@CreateCompanyTask', [$data, $request->user_ids]);

        return $company;
    }
}
