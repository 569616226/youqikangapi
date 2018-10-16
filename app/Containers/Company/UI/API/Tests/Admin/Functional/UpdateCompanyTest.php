<?php

namespace App\Containers\Company\UI\API\Tests\Admin\Functional;

use App\Containers\Company\Models\Company;
use App\Containers\Company\Tests\TestCase;

/**
 * Class UpdateCompanyTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdateCompanyTest extends TestCase
{

    protected $endpoint = 'patch@v1/companies/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-companies',
    ];

    public function testUpdateExistingCompany_()
    {

        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $this->company->users()->attach($this->userB->id);

        $revisionHistory = $this->company->revisionHistory->count();

        $data = [
            'name'     => 'update#manager',
            'user_ids' => [$this->userA->getHashedKey()],
            'logo'     => $this->faker->imageUrl(80, 80),
        ];

        // send the HTTP request
        $response = $this->injectId($this->company->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '客户更新成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('companies', [
            'name' => $data['name'],
            'logo' => $data['logo'],
        ]);

        $update_company = Company::find($this->company->id);
        $update_company_user = $update_company->users->first();

        $this->assertEquals($update_company_user->id, $this->userA->id);

        $this->assertCount($revisionHistory + 2, $update_company->revisionHistory);
    }


}


