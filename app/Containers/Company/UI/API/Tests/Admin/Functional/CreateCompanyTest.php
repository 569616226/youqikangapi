<?php

namespace App\Containers\Company\UI\API\Tests\Admin\Functional;

use App\Containers\Company\Models\Company;
use App\Containers\Company\Tests\TestCase;
use App\Containers\Plan\Models\Plan;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateCompanyTest extends TestCase
{

    protected $endpoint = 'post@v1/companies';

    protected $auth = true;

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-companies',
    ];

    public function testCreateCompany_()
    {
        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $plan = factory(Plan::class)->create();

        $data = [
            'name'     => 'manager',
            'user_ids' => [$this->userB->getHashedKey(), $this->userA->getHashedKey()],
            'logo'     => $this->faker->imageUrl(80, 80),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $data['name'] . ' 客户新建成功',
        ]);

        $company = Company::whereName($data['name'])->first();

        $this->assertCount(1, $company->revisionHistory);

    }

}
