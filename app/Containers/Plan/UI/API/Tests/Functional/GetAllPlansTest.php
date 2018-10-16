<?php

namespace App\Containers\Plan\UI\API\Tests\Functional;

use App\Containers\Plan\Models\Plan;
use App\Containers\Plan\Tests\TestCase;

/**
 * Class GetAllPlansTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllPlansTest extends TestCase
{

    protected $endpoint = 'get@v1/plans';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testGetAllPlans_()
    {
        $this->getTestingUser();

        factory(Plan::class)->create([
            'is_parent'  => true,
            'created_at' => now()
        ]);

        $plan = factory(Plan::class)->create([
            'created_at' => now()->addDay()
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(23, $responseContent->data);

        $this->assertEquals($plan->name, $responseContent->data[0]->name);
    }

}
