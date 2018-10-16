<?php

namespace App\Containers\Plan\UI\API\Transformers\Mobile;

use App\Containers\Plan\Models\Plan;
use App\Containers\PlanDepart\UI\API\Transformers\Mobile\MobilePlanDepartTransformer;
use App\Containers\PlanDepart\UI\API\Transformers\PlanDepartTransformer;
use App\Ship\Parents\Transformers\Transformer;

class MobilePlanTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [
        'plan_departs'
    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    /**
     * @param Plan $entity
     *
     * @return array
     */
    public function transform(Plan $entity)
    {

        $plan_depart_question_counts = 0;
        $plan_depart_question_status = [];
        foreach ($entity->plan_departs as $plan_depart) {
            $plan_depart_question_counts += $plan_depart->plan_depart_questions->count();

            $question_status = $plan_depart->plan_depart_questions->pluck('status')->toArray();
            $plan_depart_question_status = array_merge($plan_depart_question_status, $question_status);
        }

        /*是否全部完成*/
        if (count(array_unique($plan_depart_question_status)) == 1 && $plan_depart_question_status[0] == '审核成功') {
            $is_finish = true;
        } else {
            $is_finish = false;
        }

        $response = [
            'object'                      => 'Plan',
            'id'                          => $entity->getHashedKey(),
            'name'                        => $entity->name,
            'editer'                      => $entity->editer,
            'is_parent'                   => $entity->is_parent,
            'is_finish'                   => $is_finish,
            'plan_depart_counts'          => $entity->plan_departs->count(),
            'plan_depart_question_counts' => $plan_depart_question_counts,
            'created_at'                  => $entity->created_at->toDateTimeString(),
            'updated_at'                  => $entity->updated_at->toDateTimeString(),
            'deleted_at'                  => $entity->deleted_at ? $entity->deleted_at->toDateTimeString() : null,
        ];

        $response = $this->ifAdmin([
            'real_id' => $entity->id,
        ], $response);

        return $response;

    }

    public function includePlanDeparts(Plan $entity)
    {
        return $this->collection($entity->plan_departs, new MobilePlanDepartTransformer());
    }
}
