<?php

namespace App\Containers\Company\UI\API\Tests\Admin\Functional;

use App\Containers\Company\Models\Company;
use App\Containers\Company\Tests\TestCase;

/**
 * Class GetAllCompaniesTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllCompaniesTest extends TestCase
{

    protected $endpoint = 'get@v1/companies';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-companies',
    ];

    public function testGetAllCompanies_()
    {
        $this->getTestingUser();

        factory(Company::class, 1)->create();


        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertCount(23, $responseContent->data);

        $this->assertEquals($this->company_last->name, $responseContent->data[0]->name);
    }

}
