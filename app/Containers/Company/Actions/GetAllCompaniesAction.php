<?php

namespace App\Containers\Company\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllCompaniesAction extends Action
{
    public function run(Request $request)
    {
        $companies = Apiato::call('Company@GetAllCompaniesTask', [true], ['ordered']);

        return $companies;
    }
}
