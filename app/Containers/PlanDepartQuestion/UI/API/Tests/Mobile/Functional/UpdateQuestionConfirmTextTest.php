<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateQuestionConfirmTextTest extends TestCase
{

    protected $endpoint = 'patch@v1/plan_depart_questions/{id}/update_question_confirm_text';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testUpdateQuestionConfirmTextTest_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin'
        ]);

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        $data = [
            'confirm_text' => 'confirm_text',
        ];

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '现场确认添加成功',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);

        $this->assertEquals($data['confirm_text'], $update_plan_depart_question->confirm_text);
        $this->assertEquals($user->username, $update_plan_depart_question->confirm_editer);
        $this->assertNotNull($update_plan_depart_question->confirm_at);
        $this->assertCount($revisionHistory + 2, $update_plan_depart_question->revisionHistory);
    }

}


