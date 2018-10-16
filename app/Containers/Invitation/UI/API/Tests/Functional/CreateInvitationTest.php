<?php

namespace App\Containers\Invitation\UI\API\Tests\Functional;

use App\Containers\Order\Tests\TestCase;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateInvitationTest extends TestCase
{

  protected $endpoint = 'post@v1/reports/{id}/invitations';

  protected $auth = true;

  protected $access = [
    'roles'       => '',
    'permissions' => '',
  ];

  public function testCreateInvitation_()
  {
    $user = $this->getTestingUser([
      'username' => 'admin'
    ]);

    $data = [
      'depart_ids' => [$this->plan_depart->getHashedKey()],
    ];

    // send the HTTP request
    $response = $this->injectId($this->report->id)->makeCall($data);

    // assert response status is correct
    $response->assertStatus(200);

    $responseContent = $this->getResponseContentObject();

    $this->assertNotNull($responseContent->data->code);
    $this->assertTrue(in_array($this->plan_depart->id, $responseContent->data->depart_ids));
    $this->assertEquals($user->invitations->first()->getHashedKey(), $responseContent->data->id);

  }

}
