<?php

namespace App\Containers\Company\UI\API\Tests\Admin\Functional;

use App\Containers\Company\Tests\TestCase;

/**
 * Class FindCompanyTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindCompanyTest extends TestCase
{

    protected $endpoint = 'get@v1/companies/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-companies',
    ];

    public function testFindCompanyById_()
    {
        $admin = $this->getTestingUser([
            'username' => '系统'
        ]);

        $this->company->users()->attach([$this->userA->id, $this->userB->id]);

        // send the HTTP request
        $response = $this->injectId($this->company->id)->makeCall();
        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->company->name, $responseContent->data->name);
        $this->assertEquals($this->company->logo, $responseContent->data->logo);
        $this->assertEquals($admin->username, $responseContent->data->creator);
        $this->assertNotNull($responseContent->data->users);
    }

}
