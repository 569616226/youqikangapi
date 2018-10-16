<?php

namespace App\Containers\Plan\UI\API\Tests\Functional;

use App\Containers\Plan\Tests\TestCase;

/**
 * Class FindPlanTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class FindPlanTest extends TestCase
{

    protected $endpoint = 'get@v1/plans/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testFindPlanById_()
    {
        // send the HTTP request
        $response = $this->injectId($this->plan->id)->makeCall();

        // assert response status is correct
        $response->assertStatus(200);

        $responseContent = $this->getResponseContentObject();

        $this->assertEquals($this->plan->name, $responseContent->data->name);
        $this->assertEquals($this->plan->editer, $responseContent->data->editer);
        $this->assertEquals(2, $responseContent->data->plan_depart_counts);
        $this->assertEquals(2, $responseContent->data->plan_depart_question_counts);
        $this->assertEquals(false, $responseContent->data->is_parent);
        $this->assertNotNull($responseContent->data->plan_departs);
        $this->assertNotNull($responseContent->data->plan_departs->data[0]->plan_depart_questions);
    }

}
