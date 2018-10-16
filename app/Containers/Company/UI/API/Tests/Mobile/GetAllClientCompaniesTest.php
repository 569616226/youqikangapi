<?php

namespace App\Containers\Company\UI\API\Tests\Mobile\Functional;

use App\Containers\Company\Tests\TestCase;
use App\Containers\Invitation\Models\Invitation;
use App\Containers\User\Models\User;

/**
 * Class GetAllCompaniesTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllClientCompaniesTest extends TestCase
{

    protected $endpoint = 'get@v1/client_companies';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testGetAllClientCompaniesWithClientAdmin_()
    {

        $user = $this->getTestingUser([
            'is_client'       => true,
            'is_client_admin' => true,
        ]);

        $user->companies()->attach([
            $this->company->id,
            $this->company_last->id
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(2, $responseContent->data);

        $this->assertEquals($this->company_last->name, $responseContent->data[0]->name);
    }

    public function testGetAllClientCompaniesWithAdminUser_()
    {

        $user = $this->getTestingUser([
            'is_client' => false,
        ]);

        $user->companies()->attach([
            $this->company->id,
            $this->company_last->id
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(401);

    }

    public function testGetAllClientCompaniesWithClient_()
    {

        $user = $this->getTestingUser([
            'is_client'       => true,
            'is_client_admin' => false,
        ]);

        $client_admin = factory(User::class)->create([
            'is_client'       => true,
            'is_client_admin' => true,
        ]);

        $invitation = factory(Invitation::class)->create([
            'report_id'  => $this->report->id,
            'depart_ids' => $this->report->report_departs->pluck('id')->toArray()
        ]);

        $invitation->users()->attach([
            $user->id         => ['is_client' => true],
            $client_admin->id => ['is_client' => false]
        ]);

        $user->companies()->attach([
            $this->company->id,
            $this->company_last->id
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(1, $responseContent->data);

        $this->assertEquals($this->company_last->name, $responseContent->data[0]->name);
    }

    public function testGetAllClientCompaniesWithClientAdminHasInvitation_()
    {

        $user = $this->getTestingUser([
            'is_client'       => true,
            'is_client_admin' => true,
        ]);

        $client = factory(User::class)->create([
            'is_client'       => true,
            'is_client_admin' => false,
        ]);

        $invitation = factory(Invitation::class)->create([
            'report_id'  => $this->report->id,
            'depart_ids' => $this->report->report_departs->pluck('id')->toArray()
        ]);

        $invitation->users()->attach([
            $user->id   => ['is_client' => false],
            $client->id => ['is_client' => true]
        ]);


        $user->companies()->attach([
            $this->company->id,
            $this->company_last->id
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(2, $responseContent->data);

        $this->assertEquals($this->company_last->name, $responseContent->data[0]->name);
    }

}
