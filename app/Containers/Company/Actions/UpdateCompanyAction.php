<?php

namespace App\Containers\Company\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdateCompanyAction extends Action
{
    public function run(Request $request)
    {
        $data = [
            'name' => $request->name,
            'logo' => $request->logo ?? config('company-container.default_logo_url'),
        ];


        $company = Apiato::call('Company@UpdateCompanyTask', [$request->id, $data, $request->user_ids]);

        return $company;
    }
}
