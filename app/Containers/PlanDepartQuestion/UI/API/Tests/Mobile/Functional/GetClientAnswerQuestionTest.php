<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetClientAnswerQuestionTest extends TestCase
{

    protected $endpoint = 'patch@v1/plan_depart_questions/{id}/client_answer_question';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testGetClientAnswerQuestion_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin'
        ]);


        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        $data = [
            'client_answer' => '是',
        ];

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '问题回答成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('plan_depart_questions', [
            'client_answer'        => $data['client_answer'],
            'client_answer_editer' => $user->username,
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);

        $this->assertEquals($data['client_answer'], $update_plan_depart_question->client_answer);
        $this->assertEquals($user->username, $update_plan_depart_question->client_answer_editer);
        $this->assertEquals('调查中', $update_plan_depart_question->status);
        $this->assertCount($revisionHistory + 2, $update_plan_depart_question->revisionHistory);
    }

}


