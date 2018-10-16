<?php

namespace App\Containers\QuestionDetail\UI\API\Tests\Mobile\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Tests\TestCase;
use App\Containers\QuestionDetail\Models\QuestionDetail;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateQuestionDetailTest extends TestCase
{

    protected $endpoint = 'patch@v1/question_details/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testUpdateExistingQuestionDetail_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin'
        ]);

        $revisionHistory = $this->question_detail->revisionHistory->count();

        $data = [
            'question' => 'update#question',
            'answer'   => 'update#question',
        ];

        // send the HTTP request
        $response = $this->injectId($this->question_detail->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '提问编辑成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('question_details', [
            'question' => $data['question'],
        ]);

        $update_question_detail = QuestionDetail::find($this->question_detail->id);
        $update_plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$this->plan_depart_question->id]);

        $this->assertEquals($data['question'], $update_question_detail->question);
        $this->assertEquals($data['answer'], $update_question_detail->answer);
        $this->assertEquals($user->username, $update_plan_depart_question->client_answer_editer);
        $this->assertCount($revisionHistory + 2, $update_question_detail->revisionHistory);
    }

}


