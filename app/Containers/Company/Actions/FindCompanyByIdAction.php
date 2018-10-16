<?php

namespace App\Containers\Company\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class FindCompanyByIdAction extends Action
{
    public function run(Request $request)
    {
        $company = Apiato::call('Company@FindCompanyByIdTask', [$request->id]);

        return $company;
    }
}
