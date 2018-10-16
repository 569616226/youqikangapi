<?php

namespace App\Containers\Order\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Models\Order;
use App\Containers\Order\Tests\TestCase;

/**
 * Class GetAllCompaniesTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllOrdersTest extends TestCase
{

    protected $endpoint = 'get@v1/orders';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-orders',
    ];

    public function testGetAllOrder_()
    {
        $this->getTestingUser();

        factory(Order::class, 1)->create([
            'plan_id'    => $this->plan->id,
            'company_id' => $this->company->id,
            'created_at' => now()
        ]);

        $order = factory(Order::class)->create([
            'plan_id'    => $this->plan->id,
            'company_id' => $this->company->id,
            'created_at' => now()->addDay()
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(23, $responseContent->data);

        $this->assertEquals($order->name, $responseContent->data[0]->name);
    }

}
