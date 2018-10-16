<?php

namespace App\Containers\QuestionDetail\UI\API\Tests\Mobile\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\QuestionDetail\Models\QuestionDetail;

/**
 * Class DeletePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class DeleteQuestionDetailTest extends TestCase
{

    protected $endpoint = 'delete@v1/question_details/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testDeleteExistingPlanDepartQuetion_()
    {
        $user = $this->getTestingUser([
            'username' => 'admin'
        ]);

        /*
         * 删除方案
         *
         * */
        $revisionHistory = $this->question_detail->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($this->question_detail->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '问题删除成功',
        ]);

        $deleted_question_detail = QuestionDetail::withTrashed()->find($this->question_detail->id);
        $update_plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$this->plan_depart_question->id]);

        $this->assertEquals($user->username, $update_plan_depart_question->client_answer_editer);

        $this->assertCount($revisionHistory + 1, $deleted_question_detail->revisionHistory);
    }


    public function testDeleteExistingCompanyQuestionDetail_()
    {

        /*
         * 删除方案
         *
         * 如果方案已经被使用,就不能删除和编辑
         * */

        $revisionHistory = $this->question_detail_2->revisionHistory()->count();

        // send the HTTP request
        $response = $this->injectId($this->question_detail_2->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '该方案的订单已经完成,不能编辑删除方案内容',
        ]);

        $deleted_question_detail = QuestionDetail::withTrashed()->find($this->question_detail_2->id);

        $this->assertCount($revisionHistory, $deleted_question_detail->revisionHistory);
    }

}
