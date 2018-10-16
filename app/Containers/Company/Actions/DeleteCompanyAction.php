<?php

namespace App\Containers\Company\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class DeleteCompanyAction extends Action
{
    public function run(Request $request)
    {
        return Apiato::call('Company@DeleteCompanyTask', [$request->id]);
    }
}
