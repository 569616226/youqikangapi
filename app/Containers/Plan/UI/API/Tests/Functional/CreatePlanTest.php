<?php

namespace App\Containers\Plan\UI\API\Tests\Functional;

use App\Containers\Plan\Models\Plan;
use App\Containers\Plan\Tests\TestCase;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreatePlanTest extends TestCase
{

    protected $endpoint = 'post@v1/plans';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testCreatePlan_()
    {
        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $data = [
            'plan_data' => [
                'name'         => $this->faker->name,
                'plan_departs' => [
                    [
                        'name'                  => $this->faker->name,
                        'icon'                  => $this->faker->imageUrl(80, 80),
                        'plan_depart_questions' => [
                            [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => $this->faker->name,
                        'icon'                  => $this->faker->imageUrl(80, 80),
                        'plan_depart_questions' => [
                            [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => $this->faker->name,
                        'icon'                  => $this->faker->imageUrl(80, 80),
                        'plan_depart_questions' => [
                            [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => $this->faker->name,
                        'icon'                  => $this->faker->imageUrl(80, 80),
                        'plan_depart_questions' => [
                            [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ],

                ]

            ],
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '方案新建成功',
        ]);

        $plans = Plan::whereName($data['plan_data']['name'])->get();

        $this->assertCount(1, $plans);
        $plan_departs = $plans->first()->plan_departs;
        $this->assertCount(4, $plan_departs);
        $this->assertCount(2, $plan_departs->first()->plan_depart_questions);
        $this->assertCount(1, $plans);
        $this->assertCount(1, $plans->first()->revisionHistory);

    }

}
