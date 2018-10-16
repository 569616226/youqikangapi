<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Authorization\Models\Role;
use App\Containers\Company\Models\Company;
use App\Containers\Plan\Models\Plan;
use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;
use Dreamfishers\SystemActionLog\Models\SystemActionLog;

/**
 * Class CreateAdminTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateClientTest extends TestCase
{

    protected $endpoint = 'post@v1/clients';

    protected $access = [
        'permissions' => 'create-users',
        'roles'       => '',
    ];

    public function testCreateClient_()
    {
        $this->getTestingUser();


        $company = factory(Company::class)->create();

        $data = [
            'username'        => $this->faker->name,
            'phone'           => $this->faker->unique()->phoneNumber,
            'company_id'      => [$company->getHashedKey()],
            'is_client_admin' => true,
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $data['username'] . ' 联系人创建成功',
        ]);

        // assert the data is stored in the database
        $this->assertDatabaseHas('users', [
            'username' => $data['username'],
            'phone'    => $data['phone']
        ]);

        $user = User::where(['phone' => $data['phone']])->first();

        $this->assertEquals($user->is_client, true);
        $this->assertEquals($user->is_client_admin, true);
        $this->assertTrue(in_array('guest', $user->roles->pluck('name')->toArray()));
        $this->assertTrue(in_array($company->id, $user->companies->pluck('id')->toArray()));

        $this->assertCount(1, $user->revisionHistory);

    }

    public function testCreateClientError_()
    {
        $this->getTestingUser();

        $company = factory(Company::class)->create();
        factory(User::class)->create([
            'phone' => '13411001456'
        ]);

        $data = [
            'username'        => $this->faker->name,
            'phone'           => '13411001456',
            'company_id'      => [$company->getHashedKey()],
            'is_client_admin' => true,
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '此手机号码已被使用',
        ]);

    }

}
