<?php

namespace App\Containers\QuestionDetail\UI\API\Transformers;

use App\Containers\QuestionDetail\Models\QuestionDetail;
use App\Ship\Parents\Transformers\Transformer;

class QuestionDetailTransformer extends Transformer
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
     * @param QuestionDetail $entity
     *
     * @return array
     */
    public function transform(QuestionDetail $entity)
    {
        $response = [
            'object'     => 'QuestionDetail',
            'id'         => $entity->getHashedKey(),
            'question'   => $entity->question,
            'answer'     => $entity->answer,
            'created_at' => $entity->created_at->toDateTimeString(),
            'updated_at' => $entity->updated_at->toDateTimeString(),
            'deleted_at' => $entity->deleted_at ? $entity->deleted_at->toDateTimeString() : null,
        ];

        return $response;
    }
}
