<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateQuestionConclusionTextTest extends TestCase
{

    protected $endpoint = 'patch@v1/plan_depart_questions/{id}/update_question_conclusion_text';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testUpdateQuestionConclusionTextTest_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin'
        ]);

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        $data = [
            'conclusion_status' => '严重',
            'conclusion'        => 'confirm_text',
        ];

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '最终结论添加成功',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);

        $this->assertEquals($data['conclusion_status'], $update_plan_depart_question->conclusion_status);
        $this->assertEquals($data['conclusion'], $update_plan_depart_question->conclusion);
        $this->assertEquals($user->username, $update_plan_depart_question->conclusion_editer);
        $this->assertEquals('审核中', $update_plan_depart_question->status);
        $this->assertCount($revisionHistory + 4, $update_plan_depart_question->revisionHistory);
    }

}


