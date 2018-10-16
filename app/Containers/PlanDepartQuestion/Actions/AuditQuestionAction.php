<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class AuditQuestionAction extends Action
{
    public function run(Request $request)
    {

        $data = [
            'status'     => $request->status,
            'audit_text' => $request->audit_text,
            'auditer'    => \Auth::user()->username,
            'audit_at'   => now(),
        ];

        return Apiato::call('PlanDepartQuestion@AuditQuestionTask', [
            $request->id,
            $data
        ]);

    }
}
