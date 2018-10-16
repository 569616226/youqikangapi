<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\PlanDepartQuestion\UI\API\Requests\CreatePlanDepartQuestionRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\DeletePlanDepartQuestionRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\FindPlanDepartQuestionByIdRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\GetAllPlanDepartQuestionsRequest;
use App\Containers\PlanDepartQuestion\UI\API\Requests\UpdatePlanDepartQuestionRequest;
use App\Containers\PlanDepartQuestion\UI\API\Transformers\PlanDepartQuestionTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\PlanDepartQuestion\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     * @param CreatePlanDepartQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPlanDepartQuestion(CreatePlanDepartQuestionRequest $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@CreatePlanDepartQuestionAction', [$request]);

        if ($plan_depart_question instanceof PlanDepartQuestion) {
            return success_simple_respone('问题新建成功');
        } else {
            return $plan_depart_question;
        }

    }

    /**
     * @param FindPlanDepartQuestionByIdRequest $request
     * @return array
     */
    public function findPlanDepartQuestionById(FindPlanDepartQuestionByIdRequest $request)
    {
        $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdAction', [$request]);

        return $this->transform($plan_depart_question, PlanDepartQuestionTransformer::class);
    }

    /**
     * @param GetAllPlanDepartQuestionsRequest $request
     * @return array
     */
    public function getAllPlanDepartQuestions(GetAllPlanDepartQuestionsRequest $request)
    {
        $plan_depart_questions = Apiato::call('PlanDepartQuestion@GetAllPlanDepartQuestionsAction', [$request]);

        return $this->transform($plan_depart_questions, PlanDepartQuestionTransformer::class);
    }

    /**
     * @param UpdatePlanDepartQuestionRequest $request
     * @return array
     */
    public function updatePlanDepartQuestion(UpdatePlanDepartQuestionRequest $request)
    {
        return Apiato::call('PlanDepartQuestion@UpdatePlanDepartQuestionAction', [$request]);

    }

    /**
     * @param DeletePlanDepartQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePlanDepartQuestion(DeletePlanDepartQuestionRequest $request)
    {
        return Apiato::call('PlanDepartQuestion@DeletePlanDepartQuestionAction', [$request]);

    }
}
