<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Transformers;

use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Ship\Parents\Transformers\Transformer;

class PlanDepartQuestionTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    /**
     * @param PlanDepartQuestion $entity
     *
     * @return array
     */
    public function transform(PlanDepartQuestion $entity)
    {
        $response = [
            'object'     => 'PlanDepartQuestion',
            'id'         => $entity->getHashedKey(),
            'name'       => $entity->question,
            'answers'    => $entity->answers,
            'created_at' => $entity->created_at->toDateTimeString(),
            'updated_at' => $entity->updated_at->toDateTimeString(),
            'deleted_at' => $entity->deleted_at ? $entity->deleted_at->toDateTimeString() : null,
        ];

        $response = $this->ifAdmin([
            'real_id' => $entity->id,

        ], $response);

        return $response;
    }
}
