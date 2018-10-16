<?php

namespace App\Containers\Report\UI\API\Tests\Admin\Functional;

use App\Containers\Invitation\Models\Invitation;
use App\Containers\Order\Tests\TestCase;

/**
 * Class FindReportTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindReportTest extends TestCase
{

    protected $endpoint = 'get@v1/reports/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testFindReportByIdWithClientAdmin_()
    {
        $user = $this->getTestingUser([

            'is_client'       => true,
            'is_client_admin' => true,

        ]);

        $this->company->users()->attach($user->id);

        // send the HTTP request
        $response = $this->injectId($this->report->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->report->name, $responseContent->data->name);
        $this->assertEquals($this->report->order->company->logo, $responseContent->data->company_logo);
        $this->assertCount(4, $responseContent->data->report_departs->data);

    }

    public function testFindReportByIdWithClient_()
    {
        $user = $this->getTestingUser([
            'is_client'       => true,
            'is_client_admin' => false,
        ]);

        $invitation = factory(Invitation::class)->create([

            'report_id'  => $this->report->id,
            'depart_ids' => array_random($this->report->report_departs->pluck('id')->toArray(), 2)

        ]);

        $invitation->users()->attach([
            $user->id => ['is_client' => true]
        ]);

        $this->company->users()->attach($user->id);

        // send the HTTP request
        $response = $this->injectId($this->report->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->report->name, $responseContent->data->name);
        $this->assertEquals($this->report->order->company->logo, $responseContent->data->company_logo);
        $this->assertCount(2, $responseContent->data->report_departs->data);

    }

}
