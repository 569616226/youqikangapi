<?php

namespace App\Containers\Revision\UI\API\Tests\Functional;

use App\Containers\Revision\Models\Revision;
use App\Containers\Revision\Tests\TestCase;
use App\Containers\User\Models\User;

/**
 * Class GetAllUsersTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class GetAllRevisionsTest extends TestCase
{

    protected $endpoint = 'get@v1/revisions';

    protected $access = [
        'roles'       => '',
        'permissions' => 'list-logs',
    ];

    public function testGetAllRevisions_()
    {
        // create some non-admin users who are clients
        factory(User::class)->create([
            'created_at' => now()
        ]);

        $logB = factory(Revision::class)->create([
            'created_at' => now()->addMonths(3)
        ]);

        $logA = factory(Revision::class)->create([
            'created_at' => now()->addYears(4)
        ]);

        // send the HTTP request
        $response = $this->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        // convert JSON response string to Object
        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($logB->id, $responseContent->data[0]->id);
        $this->assertNotEquals($logA->id, $responseContent->data[count($responseContent->data) - 1]->id);

    }

}
