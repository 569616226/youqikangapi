<?php

namespace App\Containers\Plan\Tests;

use App\Containers\Company\Models\Company;
use App\Containers\Order\Models\Order;
use App\Containers\Plan\Models\Plan;
use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\QuestionDetail\Models\QuestionDetail;
use App\Ship\Parents\Tests\PhpUnit\TestCase as ShipTestCase;

/**
 * Class TestCase
 *
 * Container TestCase class. Use this class to put your container specific tests helper functions.
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class TestCase extends ShipTestCase
{
    protected $plan, $plan_2, $plan_3;
    protected $plan_depart, $plan_depart_1, $plan_depart_2, $plan_depart_3;
    protected $plan_depart_question, $plan_depart_question_1, $plan_depart_question_2, $plan_depart_question_3;
    protected $question_detail, $question_detail_1, $question_detail_2;
    protected $order;
    protected $company;

    public function setUp()
    {
        parent::setUp();

        $this->plan = factory(Plan::class)->create([
            'name' => 'plan'
        ]);
        $this->plan_2 = factory(Plan::class)->create([
            'name'      => 'plan',
        ]);
        $this->plan_3 = factory(Plan::class)->create([
            'name'      => 'plan',
            'is_parent' => true,
        ]);
        $this->plan_depart = factory(PlanDepart::class)->create([
            'name'    => 'name1',
            'plan_id' => $this->plan->id,
        ]);
        $this->plan_depart_1 = factory(PlanDepart::class)->create([
            'name'    => 'name2',
            'plan_id' => $this->plan->id,
        ]);
        $this->plan_depart_2 = factory(PlanDepart::class)->create([
            'name'    => 'name3',
            'plan_id' => $this->plan_2->id,
        ]);
        $this->plan_depart_3 = factory(PlanDepart::class)->create([
            'name'    => 'name3',
            'plan_id' => $this->plan_3->id,
        ]);
        $this->plan_depart_question = factory(PlanDepartQuestion::class)->create([
            'question'       => 'question1',
            'status'         => '未开始',
            'plan_depart_id' => $this->plan_depart->id,
            'more_files'     => [
                $this->faker->imageUrl(80, 80),
                $this->faker->imageUrl(80, 80),
                $this->faker->imageUrl(80, 80),
                $this->faker->imageUrl(80, 80),
            ]
        ]);
        $this->plan_depart_question_1 = factory(PlanDepartQuestion::class)->create([
            'question'       => 'question2',
            'status'         => '未开始',
            'plan_depart_id' => $this->plan_depart->id,
        ]);
        $this->plan_depart_question_2 = factory(PlanDepartQuestion::class)->create([
            'question'       => 'question3',
            'plan_depart_id' => $this->plan_depart_2->id,
        ]);
        $this->plan_depart_question_3 = factory(PlanDepartQuestion::class)->create([
            'question'       => 'question3',
            'plan_depart_id' => $this->plan_depart_3->id,
        ]);
        $this->question_detail = factory(QuestionDetail::class)->create([
            'question'                => 'question2',
            'plan_depart_question_id' => $this->plan_depart_question->id,
        ]);
        $this->question_detail_1 = factory(QuestionDetail::class)->create([
            'question'                => 'question2',
            'plan_depart_question_id' => $this->plan_depart_question_1->id,
        ]);
        $this->question_detail_2 = factory(QuestionDetail::class)->create([
            'question'                => 'question3',
            'plan_depart_question_id' => $this->plan_depart_question_2->id,
        ]);

        $this->company = factory(Company::class)->create();
        $this->order = factory(Order::class)->create([
            'status'     => '已完成',
            'company_id' => $this->company->id,
            'plan_id'    => $this->plan_2->id,
        ]);

    }
}
