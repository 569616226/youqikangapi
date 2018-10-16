<?php

namespace App\Containers\QuestionDetail\UI\API\Tests\Mobile\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Tests\TestCase;
use App\Containers\QuestionDetail\Models\QuestionDetail;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateQuestionDetailTest extends TestCase
{

    protected $endpoint = 'post@v1/question_details';

    protected $auth = true;

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testCreateQuestionDetail_()
    {
        $user = $this->getTestingUser([
            'username' => 'admin'
        ]);

        $data = [
            'question'                => 'question',
            'answer'                  => 'ddfdsf',
            'plan_depart_question_id' => $this->plan_depart_question->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '提问追加成功',
        ]);

        $question_detail = QuestionDetail::whereQuestion($data['question'])->first();

        $update_plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByIdTask', [$this->plan_depart_question->id]);
        $this->assertEquals($question_detail->plan_depart_question->id, $update_plan_depart_question->id);
        $this->assertEquals($user->username, $update_plan_depart_question->client_answer_editer);
        $this->assertCount(1, $question_detail->revisionHistory);

    }

}
