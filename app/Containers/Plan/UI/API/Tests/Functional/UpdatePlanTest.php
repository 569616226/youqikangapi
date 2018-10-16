<?php

namespace App\Containers\Plan\UI\API\Tests\Functional;

use App\Containers\Plan\Models\Plan;
use App\Containers\Plan\Tests\TestCase;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;

/**
 * Class UpdatePlanTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UpdatePlanTest extends TestCase
{

    protected $endpoint = 'patch@v1/plans/{id}';

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-plans',
    ];

    public function testUpdateExistingPlan_()
    {

        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $revisionHistory = $this->plan->revisionHistory->count();

        $data = [
            'plan_data' => [
                'name'         => $this->faker->name,
                'plan_departs' => [
                    [
                        'name'                  => $this->faker->name,
                        'icon'                  => $this->faker->imageUrl(80, 80),
                        'id'                    => $this->plan_depart->getHashedKey(),
                        'plan_depart_questions' => [
                            [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                                'id'       => $this->plan_depart_question->getHashedKey(),
                            ], [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                                'id'       => $this->plan_depart_question_1->getHashedKey(),
                                'del'      => true,
                            ], [
                                'question' => $this->faker->name,
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => $this->faker->name,
                        'icon'                  => $this->faker->imageUrl(80, 80),
                        'id'                    => $this->plan_depart_1->getHashedKey(),
                        'del'                   => true,
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
        $response = $this->injectId($this->plan->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '方案更新成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('plans', [
            'name' => $data['plan_data']['name'],
        ]);

        $update_plan = Plan::find($this->plan->id);
        $update_plan_depart = PlanDepart::find($this->plan_depart->id);

        $this->assertEquals($data['plan_data']['name'], $update_plan->name);
        $this->assertEquals($data['plan_data']['plan_departs'][0]['name'], $update_plan_depart->name);
        $this->assertCount(3, $update_plan->plan_departs);
        $this->assertCount(2, $update_plan_depart->plan_depart_questions);
        $this->assertTrue(!in_array($this->plan_depart_1->id, $update_plan->plan_departs->pluck('id')->toArray()));
        $this->assertTrue(!in_array($this->plan_depart_question_1->id, $update_plan_depart->plan_depart_questions->pluck('id')->toArray()));

        $this->assertCount($revisionHistory + 1, $update_plan->revisionHistory);
    }

    public function testUpdateExistingPlanName_()
    {

        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $revisionHistory = $this->plan->revisionHistory->count();

        $data = [
            'plan_data' => [
                'name' => 'manager',
            ],
        ];


        // send the HTTP request
        $response = $this->injectId($this->plan->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => true,
            'msg'    => '方案更新成功',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('plans', [
            'name' => $data['plan_data']['name'],
        ]);

        $update_plan = Plan::find($this->plan->id);
        $update_plan_depart = PlanDepart::find($this->plan_depart->id);


        $this->assertCount(2, $update_plan->plan_departs);
        $this->assertCount(2, $update_plan_depart->plan_depart_questions);

        $this->assertCount($revisionHistory + 1, $update_plan->revisionHistory);
    }

    public function testUpdateExistingPlanHasOrder_()
    {

        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $plan_depart = factory(PlanDepart::class)->create([
            'name'    => 'name1',
            'plan_id' => $this->plan_2->id,
        ]);
        $plan_depart_1 = factory(PlanDepart::class)->create([
            'name'    => 'name2',
            'plan_id' => $this->plan_2->id,
        ]);
        $plan_depart_question = factory(PlanDepartQuestion::class)->create([
            'question'       => 'question1',
            'plan_depart_id' => $plan_depart->id,
        ]);
        $plan_depart_question_1 = factory(PlanDepartQuestion::class)->create([
            'question'       => 'question2',
            'plan_depart_id' => $plan_depart->id,
        ]);

        $revisionHistory = $this->plan_2->revisionHistory->count();

        $data = [
            'plan_data' => [
                'name'         => 'manager',
                'plan_departs' => [
                    [
                        'name'                  => 'depart_name1',
                        'icon'                  => $this->faker->imageUrl(80, 80),
                        'id'                    => $plan_depart->getHashedKey(),
                        'plan_depart_questions' => [
                            [
                                'question' => 'question_1',
                                'answers'  => ['yes', 'no'],
                                'id'       => $plan_depart_question->getHashedKey(),
                            ], [
                                'question' => 'question_2',
                                'answers'  => ['yes', 'no'],
                                'id'       => $plan_depart_question_1->getHashedKey(),
                                'del'      => true,
                            ], [
                                'question' => 'question_3',
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => 'depart_name2',
                        'icon'                  => $this->faker->imageUrl(80, 80),
                        'id'                    => $plan_depart_1->getHashedKey(),
                        'del'                   => true,
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
                        'name'                  => 'depart_name3',
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
                        'name'                  => 'depart_name4',
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
        $response = $this->injectId($this->plan_2->id)->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeyValue([
            'status' => false,
            'msg'    => '该方案的订单已经完成,不能编辑删除方案内容',
        ]);

        // assert data was updated in the database
        $this->assertDatabaseHas('plans', [
            'name' => $this->plan_2->name,
        ]);

        $update_plan = Plan::find($this->plan_2->id);
        $update_plan_depart = PlanDepart::find($plan_depart->id);

        $this->assertEquals($this->plan_2->name, $update_plan->name);
        $this->assertEquals($this->plan_depart->name, $update_plan_depart->name);
        $this->assertCount(3, $update_plan->plan_departs);
        $this->assertCount(2, $update_plan_depart->plan_depart_questions);
        $this->assertTrue(in_array($plan_depart_1->id, $update_plan->plan_departs->pluck('id')->toArray()));
        $this->assertTrue(in_array($plan_depart_question_1->id, $update_plan_depart->plan_depart_questions->pluck('id')->toArray()));

        $this->assertCount($revisionHistory, $update_plan->revisionHistory);
    }

}


