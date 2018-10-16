<?php

namespace App\Containers\User\UI\API\Tests\Functional;

use App\Containers\Authentication\Tests\TestCase;
use Illuminate\Support\Facades\DB;

/**
 * Class ProxyLoginTest
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class ProxyLoginTest extends TestCase
{

    protected $endpoint; // testing multiple endpoints form the tests

    protected $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    private $testingFilesCreated = false;

    public function testClientWebAdminProxyLogin_()
    {
        $endpoint = 'post@v1/clients/web/admin/login';

        // create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'name'     => 'testing',
            'password' => 'testingpass'
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        $clientId = '100';
        $clientSecret = 'XXp8x4QK7d3J9R7OVRXWrhc19XPRroHTTKIbY8XX';

        // create client
        DB::table('oauth_clients')->insert([
            [
                'id'                     => $clientId,
                'secret'                 => $clientSecret,
                'name'                   => 'Testing',
                'redirect'               => 'http://localhost',
                'password_client'        => '1',
                'personal_access_client' => '0',
                'revoked'                => '0',
            ],
        ]);

        // make the clients credentials available as env variables
        putenv('CLIENT_WEB_ADMIN_ID=' . $clientId);
        putenv('CLIENT_WEB_ADMIN_SECRET=' . $clientSecret);

        // create testing oauth keys files
        $publicFilePath = $this->createTestingKey('oauth-public.key');
        $privateFilePath = $this->createTestingKey('oauth-private.key');

        $response = $this->endpoint($endpoint)->makeCall($data);

        $response->assertStatus(200);

        $response->assertCookie('refreshToken');

        $this->assertResponseContainKeyValue([
            'token_type' => 'Bearer',
        ]);

        $this->assertResponseContainKeys(['expires_in', 'access_token']);

        // delete testing keys files if they were created for this test
        if ($this->testingFilesCreated) {
            unlink($publicFilePath);
            unlink($privateFilePath);
        }

        $revisionHistory = \Auth::user()->revisionHistory()->count();

        $this->assertEquals(2, $revisionHistory);
    }

    public function testClientWebAdminProxyUnconfirmedLogin_()
    {
        $endpoint = 'post@v1/clients/web/admin/login';

        // create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'name'      => 'testing',
            'password'  => 'testingpass',
            'confirmed' => false,
        ];

        $user = $this->getTestingUser($data);

        $this->actingAs($user, 'web');

        $clientId = '100';
        $clientSecret = 'XXp8x4QK7d3J9R7OVRXWrhc19XPRroHTTKIbY8XX';

        // create client
        DB::table('oauth_clients')->insert([
            [
                'id'                     => $clientId,
                'secret'                 => $clientSecret,
                'name'                   => 'Testing',
                'redirect'               => 'http://localhost',
                'password_client'        => '1',
                'personal_access_client' => '0',
                'revoked'                => '0',
            ],
        ]);

        // make the clients credentials available as env variables
        putenv('CLIENT_WEB_ADMIN_ID=' . $clientId);
        putenv('CLIENT_WEB_ADMIN_SECRET=' . $clientSecret);

        // create testing oauth keys files
        $publicFilePath = $this->createTestingKey('oauth-public.key');
        $privateFilePath = $this->createTestingKey('oauth-private.key');

        $response = $this->endpoint($endpoint)->makeCall($data);

        if (\Config::get('authentication-container.require_email_confirmation')) {
            $response->assertStatus(409);
        } else {
            $response->assertStatus(200);
        }

        // delete testing keys files if they were created for this test
        if ($this->testingFilesCreated) {
            unlink($publicFilePath);
            unlink($privateFilePath);
        }
    }


    public function testClientWebAdminProxyFrozenLogin_()
    {
        $endpoint = 'post@v1/clients/web/admin/login';

        // create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'name'      => 'testingfrozen',
            'password'  => 'testingpass',
            'is_frozen' => true,
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        $clientId = '100';
        $clientSecret = 'XXp8x4QK7d3J9R7OVRXWrhc19XPRroHTTKIbY8XX';

        // create client
        DB::table('oauth_clients')->insert([
            [
                'id'                     => $clientId,
                'secret'                 => $clientSecret,
                'name'                   => 'Testing',
                'redirect'               => 'http://localhost',
                'password_client'        => '1',
                'personal_access_client' => '0',
                'revoked'                => '0',
            ],
        ]);

        // make the clients credentials available as env variables
        putenv('CLIENT_WEB_ADMIN_ID=' . $clientId);
        putenv('CLIENT_WEB_ADMIN_SECRET=' . $clientSecret);

        // create testing oauth keys files
        $publicFilePath = $this->createTestingKey('oauth-public.key');
        $privateFilePath = $this->createTestingKey('oauth-private.key');

        $response = $this->endpoint($endpoint)->makeCall($data);

        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '账号已被冻结',
        ]);


        // delete testing keys files if they were created for this test
        if ($this->testingFilesCreated) {
            unlink($publicFilePath);
            unlink($privateFilePath);
        }
    }

    public function testClientWebAdminProxyErrorLogin_()
    {
        $endpoint = 'post@v1/clients/web/admin/login';

        // create data to be used for creating the testing user and to be sent with the post request
        $data = [
            'name'     => 'testing',
            'password' => 'testingpass',
        ];

        $user = $this->getTestingUser($data);
        $this->actingAs($user, 'web');

        $clientId = '100';
        $clientSecret = 'XXp8x4QK7d3J9R7OVRXWrhc19XPRroHTTKIbY8XX';

        // create client
        DB::table('oauth_clients')->insert([
            [
                'id'                     => $clientId,
                'secret'                 => $clientSecret,
                'name'                   => 'Testing',
                'redirect'               => 'http://localhost',
                'password_client'        => '1',
                'personal_access_client' => '0',
                'revoked'                => '0',
            ],
        ]);

        // make the clients credentials available as env variables
        putenv('CLIENT_WEB_ADMIN_ID=' . $clientId);
        putenv('CLIENT_WEB_ADMIN_SECRET=' . $clientSecret);

        // create testing oauth keys files
        $publicFilePath = $this->createTestingKey('oauth-public.key');
        $privateFilePath = $this->createTestingKey('oauth-private.key');

        $login_data = [
            'name'     => 'testing11',
            'password' => 'testingpass11',
        ];

        $response = $this->endpoint($endpoint)->makeCall($login_data);

        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '账号名或者密码错误',
        ]);


        // delete testing keys files if they were created for this test
        if ($this->testingFilesCreated) {
            unlink($publicFilePath);
            unlink($privateFilePath);
        }
    }

    /**
     * @param $fileName
     *
     * @return  string
     */
    private function createTestingKey($fileName)
    {
        $filePath = storage_path($fileName);

        if (!file_exists($filePath)) {
            $keysStubDirectory = __DIR__ . '/Stubs/';

            copy($keysStubDirectory . $fileName, $filePath);

            $this->testingFilesCreated = true;
        }

        return $filePath;
    }
}
