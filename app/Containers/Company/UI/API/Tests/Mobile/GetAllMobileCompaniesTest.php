<?php

namespace App\Containers\Company\UI\API\Tests\Mobile\Functional;

use App\Containers\Company\Models\Company;
use App\Containers\Company\Tests\TestCase;

/**
 * Class GetAllCompaniesTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllMobileCompaniesTest extends TestCase
{

    protected $endpoint = 'get@v1/mobile_companies';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testGetAllMobileCompaniesWithAdmin_()
    {
        $this->getTestingUser();

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $company_counts = Company::whereHas('orders')->get()->count();

        $this->assertCount($company_counts, $responseContent->data);
        $this->assertEquals($this->company_last->name, $responseContent->data[0]->name);
    }

    public function testGetAllMobileCompaniesWithClient_()
    {
        $this->getTestingUser([
            'is_client' => true
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(401);

    }

}
