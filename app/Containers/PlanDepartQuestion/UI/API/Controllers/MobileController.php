<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\AuditMoreQuestionRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\AuditQuestionRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\DelQuestionMoreFilesRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\FindMobilePlanDepartQuestionByIdRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\GetAllMobilePlanDepartQuestionsRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\GetClientAnswerQuestionRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\UpdateQuestionConclusionTextRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\UpdateQuestionConfirmTextRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\Mobile\UpdateQuestionMoreFilesRequest;
use App\Containers\PlanDepartQuestion\UI\API\Transformers\Mobile\MobilePlanDepartQuestionTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\PlanDepartQuestion\UI\API\Controllers
 */
class MobileController extends ApiController
{

    /**
     * @param FindMobilePlanDepartQuestionByIdRequest $request
     * @return array
     */
    public function findMobilePlanDepartQuestionById(FindMobilePlanDepartQuestionByIdRequest $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdAction', [$request]);

        return $this->transform($plan_depart_question, MobilePlanDepartQuestionTransformer::class);
    }

    /**
     * @param GetAllMobilePlanDepartQuestionsRequest $request
     * @return array
     */
    public function getAllMobilePlanDepartQuestions(GetAllMobilePlanDepartQuestionsRequest $request)
    {
        $plan_depart_questions = Apiato::call('PlanDepartQuestion@GetAllPlanDepartQuestionsAction', [$request]);

        $no_complate_question = $plan_depart_questions->filter(function ($item) {
            return $item->status == '调查中' || $item->status == '审核中' || $item->status == '未开始';
        });

        $auditing_question = $plan_depart_questions->filter(function ($item) {
            return $item->status == '审核中';
        });

        $success_audit_question = $plan_depart_questions->filter(function ($item) {
            return $item->status == '审核成功';
        });

        $not_audit_question = $plan_depart_questions->filter(function ($item) {
            return $item->status == '已驳回';
        });

        $data = [
            'success_audit'       => $this->transform($success_audit_question, MobilePlanDepartQuestionTransformer::class),
            'not_audit'           => $this->transform($not_audit_question, MobilePlanDepartQuestionTransformer::class),
            'success_audit_count' => $success_audit_question->count(),
            'not_audit_count'     => $not_audit_question->count(),
            'all_count'           => $plan_depart_questions->count(),
            'is_finish'           => $plan_depart_questions->count() == $success_audit_question->count() + $not_audit_question->count(),
        ];

        if (\Auth::user()->is_audit) {
            $all_data = [
                'auditing'       => $this->transform($auditing_question, MobilePlanDepartQuestionTransformer::class),
                'auditing_count' => $auditing_question->count(),
            ];
        } else {
            $all_data = [
                'no_complate'       => $this->transform($no_complate_question, MobilePlanDepartQuestionTransformer::class),
                'no_complate_count' => $no_complate_question->count(),
            ];

        }

        $data = array_merge($data, $all_data);

        return response()->json($data);
    }

    /**
     * @param GetClientAnswerQuestionRequest $request
     * @return array
     */
    public function getClientAnswerQuestion(GetClientAnswerQuestionRequest $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@GetClientAnswerQuestionAction', [$request]);

        if ($plan_depart_question) {
            return success_simple_respone('问题回答成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param UpdateQuestionMoreFilesRequest $request
     * @return array
     */
    public function updateQuestionMoreFiles(UpdateQuestionMoreFilesRequest $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdateQuestionMoreFilesAction', [$request]);

        if ($plan_depart_question) {
            return success_simple_respone('补充材料添加成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param UpdateQuestionMoreFilesRequest $request
     * @return array
     */
    public function delQuestionMoreFiles(DelQuestionMoreFilesRequest $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@DelQuestionMoreFilesAction', [$request]);

        if ($plan_depart_question) {
            return success_simple_respone('删除成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param UpdateQuestionConfirmTextRequest $request
     * @return array
     */
    public function updateQuestionConfirmText(UpdateQuestionConfirmTextRequest $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdateQuestionConfirmTextAction', [$request]);

        if ($plan_depart_question) {
            return success_simple_respone('现场确认添加成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param UpdateQuestionConclusionTextRequest $request
     * @return array
     */
    public function updateQuestionConClusionText(UpdateQuestionConclusionTextRequest $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@UpdateQuestionConclusionTextAction', [$request]);

        if ($plan_depart_question) {
            return success_simple_respone('最终结论添加成功');
        } else {
            return error_simple_respone();
        }
    }


    /**
     * @param AuditQuestionRequest $request
     * @return array
     */
    public function auditQuestion(AuditQuestionRequest $request)
    {
        return Apiato::call('PlanDepartQuestion@AuditQuestionAction', [$request]);
    }

    /**
     * @param AuditMoreQuestionRequest $request
     * @return array
     */
    public function auditMoreQuestion(AuditMoreQuestionRequest $request)
    {
        return Apiato::call('PlanDepartQuestion@AuditMoreQuestionAction', [$request]);
    }


}
