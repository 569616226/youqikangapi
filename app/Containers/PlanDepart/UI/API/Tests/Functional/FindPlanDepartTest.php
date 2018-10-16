<?php

namespace App\Containers\Plan\UI\API\Tests\Functional;


use App\Containers\Plan\Tests\TestCase;


/**
 * Class FindPlanTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindPlansDepartTest extends TestCase
{

    protected $endpoint = 'get@v1/plan_departs/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testFindPlanById_()
    {

        // send the HTTP request
        $response = $this->injectId($this->plan_depart->id)->makeCall();
        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->plan_depart->name, $responseContent->data->name);
        $this->assertEquals($this->plan_depart->icon, $responseContent->data->icon);

        $this->assertNotNull($responseContent->data->plan_depart_questions);

    }

}
