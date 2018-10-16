<?php

namespace App\Containers\Welcome\UI\API\Tests\Functional;

use App\Containers\Company\Models\Company;
use App\Containers\Order\Models\Order;
use App\Containers\Plan\Models\Plan;
use App\Containers\User\Models\User;
use App\Containers\Welcome\Tests\TestCase;

/**
 * Class GetAllCompaniesTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class HomePageTest extends TestCase
{

    protected $endpoint = 'get@v1/';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testHomePage_()
    {
        $this->getTestingUser();

        $plan = factory(Plan::class)->create();
        factory(Plan::class, 2)->create();
        $company = factory(Company::class)->create();
        factory(Company::class, 7)->create();
        factory(Order::class, 5)->create([
            'plan_id'    => $plan->id,
            'company_id' => $company->id,
            'created_at' => now()->addDay()
        ]);

        factory(User::class, 4)->create([
            'is_client' => true
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertEquals(25, $responseContent->data->orders);
        $this->assertEquals(28, $responseContent->data->companies);
        $this->assertEquals(24, $responseContent->data->clients);

    }

}
