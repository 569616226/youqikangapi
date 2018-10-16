<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Tests\Admin\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreatePlanDepartQuestionTest extends TestCase
{

  protected $endpoint = 'post@v1/plan_depart_questions';

  protected $auth = true;

  protected $access = [
    'roles'       => '',
    'permissions' => 'manage-plans',
  ];

  public function testCreatePlanDepartQuestion_()
  {
    $this->getTestingUser([
      'username' => 'admin'
    ]);

    $data = [
      'question'       => 'question',
      'answers'        => [
        '是',
        '否'
      ],
      'plan_depart_id' => $this->plan_depart->getHashedKey(),
    ];

    // send the HTTP request
    $response = $this->makeCall($data);

    // assert response status is correct
    $response->assertStatus(200);

    $this->assertResponseContainKeyValue([
      'status' => true,
      'msg'    => '问题新建成功',
    ]);

    $plan_depart_question = PlanDepartQuestion::whereQuestion($data['question'])->first();

    $this->assertEquals($plan_depart_question->plan_depart->id, $this->plan_depart->id);
    $this->assertCount(1, $plan_depart_question->revisionHistory);

  }

  public function testCreateParentPlanPlanDepartQuestion_()
  {
    $user = $this->getTestingUser([
      'username' => 'admin'
    ]);

    $data = [
      'question'       => 'question',
      'answers'        => [
        '是',
        '否'
      ],
      'plan_depart_id' => $this->plan_depart_3->getHashedKey(),
    ];

    // send the HTTP request
    $response = $this->makeCall($data);

    // assert response status is correct
    $response->assertStatus(200);

    $this->assertResponseContainKeyValue([
      'status' => true,
      'msg'    => '问题新建成功',
    ]);

    $plan_depart_question = PlanDepartQuestion::whereQuestion($data['question'])->first();

    $this->assertEquals($plan_depart_question->plan_depart->id, $this->plan_depart_3->id);
    $this->assertEquals($user->username, $plan_depart_question->plan_depart->plan->editer);
    $this->assertCount(1, $plan_depart_question->revisionHistory);

  }

  public function testCreatePlanDepartQuestionError_()
  {
    $this->getTestingUser([
      'username' => 'admin'
    ]);

    $data = [
      'question'       => 'question',
      'answers'        => [
        '是',
        '否'
      ],
      'plan_depart_id' => $this->plan_depart->getHashedKey(),
    ];

    factory(PlanDepartQuestion::class)->create(
      [
        'question'       => 'question',
        'answers'        => [
          '是',
          '否'
        ],
        'plan_depart_id' => $this->plan_depart->id,
      ]

    );

    // send the HTTP request
    $response = $this->makeCall($data);

    // assert response status is correct
    $response->assertStatus(200);

    $this->assertResponseContainKeyValue([
      'status' => false,
      'msg'    => '问题已经存在',
    ]);

  }

}
