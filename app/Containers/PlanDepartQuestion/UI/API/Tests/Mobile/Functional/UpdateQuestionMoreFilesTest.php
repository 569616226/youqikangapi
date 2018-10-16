<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Mobile\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateQuestionMoreFilesTest extends TestCase
{

    protected $endpoint = 'patch@v1/plan_depart_questions/{id}/update_question_more_files';

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
            'more_file' => 'url',
        ];

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '补充材料添加成功',
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);

        $this->assertTrue(in_array($data['more_file'], $update_plan_depart_question->more_files));
        $this->assertEquals($user->username, $update_plan_depart_question->client_answer_editer);
        $this->assertCount($revisionHistory + 1, $update_plan_depart_question->revisionHistory);
    }

}


