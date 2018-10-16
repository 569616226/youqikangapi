<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\User\Models\User;
use App\Containers\User\Tests\TestCase;

/**
 * Class CreateAdminTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateAdminTest extends TestCase
{

    protected $endpoint = 'post@v1/admins';

    protected $access = [
        'permissions' => 'create-admins',
        'roles'       => '',
    ];

    public function testCreateAdmin_()
    {
        $this->getTestingUser();


        $role = Apiato::call('Authorization@CreateRoleTask',
            ['advisor', '顾问', '处理客户报告知道相关工作', 9999]
        );

        $data = [
            'name'     => $this->faker->name,
            'username' => $this->faker->name,
            'phone'    => $this->faker->unique()->phoneNumber,
            'password' => $this->faker->password,
            'role_id'  => $role->getHashedKey(),
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => $data['username'] . ' 用户创建成功',
        ]);

        // assert the data is stored in the database
        $this->assertDatabaseHas('users', [
            'name'     => $data['name'],
            'username' => $data['username'],
            'phone'    => $data['phone']
        ]);

        $user = User::where(['phone' => $data['phone']])->first();

        $this->assertEquals($user->is_client, false);
        $this->assertTrue(in_array($role->id, $user->roles->pluck('id')->toArray()));

        $this->assertCount(1, $user->revisionHistory);

    }

    public function testCreateAdminError_()
    {
        $this->getTestingUser(['phone' => '13412007890']);

        $role = Apiato::call('Authorization@CreateRoleTask',
            ['advisor', '顾问', '处理客户报告知道相关工作', 9999]
        );

        $data = [
            'name'     => $this->faker->name,
            'username' => $this->faker->name,
            'phone'    => '13412007890',
            'password' => $this->faker->password,
            'role_id'  => $role->getHashedKey(),
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
