<?php

namespace App\Containers\PlanDepartQuestion\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UpdateQuestionConfirmTextAction extends Action
{
    public function run(Request $request)
    {

        $data = [
            'confirm_text'   => html_entity_decode(stripslashes($request->confirm_text)),
            'confirm_editer' => \Auth::user()->username,
            'confirm_at'     => now(),
        ];

        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdateMobilePlanDepartQuestionTask', [$request->id, $data]);

        return $plan_depart_question;
    }
}
