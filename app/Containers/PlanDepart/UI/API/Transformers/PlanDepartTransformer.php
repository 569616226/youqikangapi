<?php

namespace App\Containers\PlanDepart\UI\API\Transformers;

use App\Containers\PlanDepart\Models\PlanDepart;
use App\Containers\PlanDepartQuestion\UI\API\Transformers\PlanDepartQuestionTransformer;
use App\Ship\Parents\Transformers\Transformer;

class PlanDepartTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [
        'plan_depart_questions'
    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    /**
     * @param PlanDepart $entity
     *
     * @return array
     */
    public function transform(PlanDepart $entity)
    {

        $questions = $entity->plan_depart_questions;
        $question_counts = $questions->count();
        $complate_question_counts = $questions->filter(function ($item) {
            return $item->status == '审核成功';
        })->count();

        $response = [
            'object'     => 'PlanDepart',
            'id'         => $entity->getHashedKey(),
            'name'       => $entity->name,
            'icon'       => $entity->icon,
            'is_finish'  => $complate_question_counts == $question_counts,
            'created_at' => $entity->created_at->toDateTimeString(),
            'updated_at' => $entity->updated_at->toDateTimeString(),
            'deleted_at' => $entity->deleted_at ? $entity->deleted_at->toDateTimeString() : null,
        ];

        $response = $this->ifAdmin([
            'real_id' => $entity->id,

        ], $response);

        return $response;
    }

    public function includePlanDepartQuestions(PlanDepart $entity)
    {
        return $this->collection($entity->plan_depart_questions, new PlanDepartQuestionTransformer());
    }
}
