<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Admin\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\Plan\Models\Plan;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdatePlanDepartQuestionTest extends TestCase
{

    protected $endpoint = 'patch@v1/plan_depart_questions/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testUpdateExistingPlanDepartQuestion_()
    {

        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $revisionHistory = $this->plan_depart_question->revisionHistory->count();

        $data = [
            'question' => $this->faker->unique()->name,
            'answers'  => ['1', '2'],
        ];

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '问题更新成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('plan_depart_questions', [
            'question' => $data['question'],
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question->id);

        $this->assertEquals($data['question'], $update_plan_depart_question->question);
        $this->assertEquals($data['answers'], $update_plan_depart_question->answers);
        $this->assertCount($revisionHistory + 2, $update_plan_depart_question->revisionHistory);
    }

    public function testUpdateExistingParentPlansPlanDepartQuestion_()
    {

        $user = $this->getTestingUser([
            'username' => 'admin'
        ]);


        $revisionHistory = $this->plan_depart_question_3->revisionHistory->count();

        $data = [
            'question' => $this->faker->unique()->name,
            'answers'  => ['1', '2'],
        ];

        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question_3->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '问题更新成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('plan_depart_questions', [
            'question' => $data['question'],
        ]);

        $update_plan_depart_question = PlanDepartQuestion::find($this->plan_depart_question_3->id);


        $this->assertEquals($data['question'], $update_plan_depart_question->question);
        $this->assertEquals($data['answers'], $update_plan_depart_question->answers);
        $this->assertEquals($user->username, $update_plan_depart_question->plan_depart->plan->editer);
        $this->assertCount($revisionHistory + 2, $update_plan_depart_question->revisionHistory);
    }

    public function testUpdateExistingPlanDepartQuestionError_()
    {

        $this->getTestingUser([
            'username' => 'admin'
        ]);

        factory(PlanDepartQuestion::class)->create(
            [
                'question'       => 'update#question',
                'answers'        => [
                    '是',
                    '否'
                ],
                'plan_depart_id' => $this->plan_depart->id,
            ]

        );

        $data = [
            'question' => 'update#question',
            'answers'  => ['1', '2'],
        ];


        // send the HTTP request
        $response = $this->injectId($this->plan_depart_question->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '问题已经存在',
        ]);

    }

}


