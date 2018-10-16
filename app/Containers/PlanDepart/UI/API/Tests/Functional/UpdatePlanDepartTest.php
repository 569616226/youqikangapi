<?php

namespace App\Containers\PlanDepart\UI\API\Tests\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepart\Models\PlanDepart;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdatePlansDepartTest extends TestCase
{

  protected $endpoint = 'patch@v1/plan_departs/{id}';

  protected $access = [
    'roles'       => '',
    'permissions' => 'manage-plans',
  ];

  public function testUpdateExistingPlanDepart_()
  {

    $this->getTestingUser([
      'username' => 'admin'
    ]);

    $revisionHistory = $this->plan_depart->revisionHistory->count();

    $data = [
      'name' => 'update#plan',
      'icon' => 'update#icon',
    ];

    // send the HTTP request
    $response = $this->injectId($this->plan_depart->id)->makeCall($data);

    // assert response status is correct
    $response->assertStatus(200);

    // assert returned user is the updated one
    $this->assertResponseContainKeyValue([
      'status' => true,
      'msg'    => '部门更新成功',
    ]);

    // assert data was updated in the database
    $this->assertDatabaseHas('plan_departs', [
      'name' => $data['name'],
      'icon' => $data['icon'],
    ]);

    $update_plan_depart = PlanDepart::find($this->plan_depart->id);
    $this->assertEquals($data['name'], $update_plan_depart->name);
    $this->assertEquals($data['icon'], $update_plan_depart->icon);
    $this->assertCount($revisionHistory + 2, $update_plan_depart->revisionHistory);
  }

  public function testUpdateExistingParentPlanPlanDepart_()
  {

    $user = $this->getTestingUser([
      'username' => 'admin'
    ]);

    $revisionHistory = $this->plan_depart_3->revisionHistory->count();

    $data = [
      'name' => 'update#plan',
      'icon' => 'update#icon',
    ];

    // send the HTTP request
    $response = $this->injectId($this->plan_depart_3->id)->makeCall($data);

    // assert response status is correct
    $response->assertStatus(200);

    // assert returned user is the updated one
    $this->assertResponseContainKeyValue([
      'status' => true,
      'msg'    => '部门更新成功',
    ]);

    // assert data was updated in the database
    $this->assertDatabaseHas('plan_departs', [
      'name' => $data['name'],
      'icon' => $data['icon'],
    ]);

    $update_plan_depart = PlanDepart::find($this->plan_depart_3->id);

    $this->assertEquals($data['name'], $update_plan_depart->name);
    $this->assertEquals($data['icon'], $update_plan_depart->icon);
    $this->assertEquals($user->username, $update_plan_depart->plan->editer);
    $this->assertCount($revisionHistory + 2, $update_plan_depart->revisionHistory);
  }

}


