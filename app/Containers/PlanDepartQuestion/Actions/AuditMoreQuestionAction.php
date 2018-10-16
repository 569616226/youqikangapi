<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class AuditMoreQuestionAction extends Action
{
    public function run(Request $request)
    {

        $data = [
            'status'   => $request->status,
            'auditer'  => \Auth::user()->username,
            'audit_at' => now(),
        ];

        return $plan_depart_question = Apiato::call('PlanDepartQuestion@AuditMoreQuestionsTask', [
            $request->question_ids,
            $data
        ]);

    }
}
