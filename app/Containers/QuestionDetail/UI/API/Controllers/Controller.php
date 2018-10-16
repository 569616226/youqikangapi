<?php

namespace App\Containers\QuestionDetail\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\QuestionDetail\UI\API\Requests\CreateQuestionDetailRequest;
use App\Containers\QuestionDetail\UI\API\Requests\DeleteQuestionDetailRequest;
use App\Containers\QuestionDetail\UI\API\Requests\FindQuestionDetailByIdRequest;
use App\Containers\QuestionDetail\UI\API\Requests\UpdateQuestionDetailRequest;
use App\Containers\QuestionDetail\UI\API\Transformers\QuestionDetailTransformer;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\QuestionDetail\UI\API\Controllers
 */
class Controller extends ApiController
{
    /**
     * @param CreateQuestionDetailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createQuestionDetail(CreateQuestionDetailRequest $request)
    {
        $question_detail = Apiato::call('QuestionDetail@CreateQuestionDetailAction', [$request]);

        if ($question_detail) {
            return success_simple_respone('提问追加成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param FindQuestionDetailByIdRequest $request
     * @return array
     */
    public function findQuestionDetailById(FindQuestionDetailByIdRequest $request)
    {
        $questiondetail = Apiato::call('QuestionDetail@FindQuestionDetailByIdAction', [$request]);

        return $this->transform($questiondetail, QuestionDetailTransformer::class);
    }


    /**
     * @param UpdateQuestionDetailRequest $request
     * @return array
     */
    public function updateQuestionDetail(UpdateQuestionDetailRequest $request)
    {
        $question_detail = Apiato::call('QuestionDetail@UpdateQuestionDetailAction', [$request]);

        if ($question_detail) {
            return success_simple_respone('提问编辑成功');
        } else {
            return error_simple_respone();
        }
    }

    /**
     * @param DeleteQuestionDetailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteQuestionDetail(DeleteQuestionDetailRequest $request)
    {
        return Apiato::call('QuestionDetail@DeleteQuestionDetailAction', [$request]);

    }
}
