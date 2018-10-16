<?php

namespace App\Containers\PlanDepart\UI\API\Tests\Functional;

use App\Containers\Plan\Models\Plan;
use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepart\Models\PlanDepart;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreatePlansDepartTest extends TestCase
{

  protected $endpoint = 'post@v1/plan_departs';

  protected $auth = true;

  protected $access = [
    'roles'       => '',
    'permissions' => 'manage-plans',
  ];

  public function testCreatePlanDepart_()
  {
    $this->getTestingUser([
      'username' => 'admin'
    ]);

    $data = [
      'name'    => 'name',
      'icon'    => 'icon',
      'plan_id' => $this->plan->getHashedKey(),
    ];

    // send the HTTP request
    $response = $this->makeCall($data);
    // assert response status is correct
    $response->assertStatus(200);

    $this->assertResponseContainKeyValue([
      'status' => true,
      'msg'    => $data['name'] . ' 部门新建成功',
    ]);

    $plan_depart = PlanDepart::whereName($data['name'])->first();

    $this->assertEquals($plan_depart->plan->id, $this->plan->id);
    $this->assertCount(1, $this->plan->revisionHistory);

  }

  public function testCreateParentPlanPlanDepart_()
  {
    $user = $this->getTestingUser([
      'username' => 'admin'
    ]);


    $data = [
      'name'    => $this->faker->name,
      'icon'    => 'icon',
      'plan_id' => $this->plan_3->getHashedKey(),
    ];

    // send the HTTP request
    $response = $this->makeCall($data);

    // assert response status is correct
    $response->assertStatus(200);

    $this->assertResponseContainKeyValue([
      'status' => true,
      'msg'    => $data['name'] . ' 部门新建成功',
    ]);

    $plan_depart = PlanDepart::whereName($data['name'])->first();
    $update_plan = Plan::find($this->plan_3->id);

    $this->assertEquals($plan_depart->plan_id, $this->plan_3->id);
    $this->assertEquals($user->username, $update_plan->editer);
    $this->assertCount(1, $this->plan_3->revisionHistory);

  }

}
