<?php

namespace App\Containers\Plan\UI\API\Tests\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Tests\TestCase;

/**
 * Class FindPlanTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindParentPlanTest extends TestCase
{

    protected $endpoint = 'get@v1/parent_plan';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testFindParentPlan_()
    {

        $plan = Apiato::call('Plan@FindParentPlanAction');

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($plan->name, $responseContent->data->name);
        $this->assertEquals($plan->editer, $responseContent->data->editer);
        $this->assertEquals(true, $responseContent->data->is_parent);
        $this->assertEquals(10, $responseContent->data->plan_depart_counts);
        $this->assertEquals(10, $responseContent->data->plan_depart_question_counts);
        $this->assertNotNull($responseContent->data->plan_departs);
        $this->assertNotNull($responseContent->data->plan_departs->data[0]->plan_depart_questions);
    }

}
