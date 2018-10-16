<?php

namespace App\Containers\PlanDepart\UI\API\Tests\Functional;

use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepart\Models\PlanDepart;

/**
 * Class GetAllPlansTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllPlansDepartsTest extends TestCase
{

    protected $endpoint = 'get@v1/plan/{id}/departs';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testGetAllPlanDeaprts_()
    {
        $this->getTestingUser();

        $plan_depart = factory(PlanDepart::class)->create([
            'plan_id'    => $this->plan->id,
            'created_at' => now()->addDay()
        ]);

        // send the HTTP request
        $response = $this->injectId($this->plan->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(3, $responseContent->data);

        $this->assertEquals($plan_depart->name, $responseContent->data[0]->name);
    }

}
