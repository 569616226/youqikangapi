<?php

namespace App\Containers\Company\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllMobileCompaniesAction extends Action
{
    public function run(Request $request)
    {
        $companies = Apiato::call('Company@GetAllMobileCompaniesTask', [], ['ordered']);

        return $companies;
    }
}
