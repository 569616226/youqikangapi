<?php

namespace App\Containers\Order\UI\API\Tests\Admin\Functional;

use App\Containers\Order\Models\Order;
use App\Containers\Order\Tests\TestCase;

/**
 * Class CreateRoleTest.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
class CreateOrderWithCreateNewPlanTest extends TestCase
{

    protected $endpoint = 'post@v1/plan_orders';

    protected $auth = true;

    protected $access = [
        'roles'       => '',
        'permissions' => 'manage-orders',
    ];


    public function testCreateOrderStartWithCreateNewPlan_()
    {
        $this->getTestingUser([
            'username' => 'admin'
        ]);

        $data = [
            'name'       => 'manager',
            'status'     => '进行中',
            'company_id' => $this->company->getHashedKey(),
            'plan_data'  => [
                'name'         => 'manager',
                'plan_departs' => [
                    [
                        'name'                  => 'depart_name',
                        'icon'                  => 'depart_icon',
                        'plan_depart_questions' => [
                            [
                                'question' => 'question',
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => 'question_1',
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => 'depart_name',
                        'icon'                  => 'depart_icon',
                        'plan_depart_questions' => [
                            [
                                'question' => 'question',
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => 'question_1',
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => 'depart_name',
                        'icon'                  => 'depart_icon',
                        'plan_depart_questions' => [
                            [
                                'question' => 'question',
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => 'question_1',
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => 'depart_name',
                        'icon'                  => 'depart_icon',
                        'plan_depart_questions' => [
                            [
                                'question' => 'question',
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => 'question_1',
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
            'msg'    => $data['name'] . ' 订单新建成功',
        ]);

        $order = Order::whereName($data['name'])->first();

        $this->assertEquals('进行中', $order->status);
        $this->assertNotNull($order->start_at);
        $this->assertCount(4, $order->plan->plan_departs);
        $plan_depart_questions = 0;
        foreach ($order->plan->plan_departs as $plan_depart) {
            $plan_depart_questions += $plan_depart->plan_depart_questions->count();
        }
        $this->assertEquals(8, $plan_depart_questions);
        $this->assertCount(1, $order->revisionHistory);

    }

    public function testCreateOrderWithCreateNewPlanDontStart_()
    {
        $this->getTestingUser([
            'username' => 'admin'
        ]);


        $data = [
            'name'       => 'manager',
            'status'     => '未开始',
            'company_id' => $this->company->getHashedKey(),
            'plan_data'  => [
                'name'         => 'manager',
                'plan_departs' => [
                    [
                        'name'                  => 'depart_name',
                        'icon'                  => 'depart_icon',
                        'plan_depart_questions' => [
                            [
                                'question' => 'question',
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => 'question_1',
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => 'depart_name',
                        'icon'                  => 'depart_icon',
                        'plan_depart_questions' => [
                            [
                                'question' => 'question',
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => 'question_1',
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => 'depart_name',
                        'icon'                  => 'depart_icon',
                        'plan_depart_questions' => [
                            [
                                'question' => 'question',
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => 'question_1',
                                'answers'  => ['yes', 'no'],
                            ],
                        ]
                    ], [
                        'name'                  => 'depart_name',
                        'icon'                  => 'depart_icon',
                        'plan_depart_questions' => [
                            [
                                'question' => 'question',
                                'answers'  => ['yes', 'no'],
                            ], [
                                'question' => 'question_1',
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
            'msg'    => $data['name'] . ' 订单新建成功',
        ]);

        $order = Order::whereName($data['name'])->first();


        $this->assertEquals('未开始', $order->status);
        $this->assertNull($order->start_at);
        $this->assertCount(4, $order->plan->plan_departs);
        $plan_depart_questions = 0;
        foreach ($order->plan->plan_departs as $plan_depart) {
            $plan_depart_questions += $plan_depart->plan_depart_questions->count();
        }
        $this->assertEquals(8, $plan_depart_questions);
        $this->assertCount(1, $order->revisionHistory);

    }

}
