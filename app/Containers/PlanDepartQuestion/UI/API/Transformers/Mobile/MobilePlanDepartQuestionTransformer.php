<?php

namespace App\Containers\PlanDepartQuestion\UI\API\Transformers\Mobile;

use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\QuestionDetail\UI\API\Transformers\QuestionDetailTransformer;
use App\Ship\Parents\Transformers\Transformer;

class MobilePlanDepartQuestionTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [
        'question_details'
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
            'object'               => 'PlanDepartQuestion',
            'id'                   => $entity->getHashedKey(),
            'name'                 => $entity->question,
            'status'               => $entity->status,
            'client_answer'        => $entity->client_answer,
            'more_files'           => $entity->more_files,
            'confirm_text'         => html_entity_decode(stripslashes($entity->confirm_text)),
            'confirm_at'           => $entity->confirm_at ? $entity->confirm_at->toDateTimeString() : null,
            'conclusion_status'    => $entity->conclusion_status,
            'conclusion_at'        => $entity->conclusion_at ? $entity->conclusion_at->toDateTimeString() : null,
            'conclusion'           => html_entity_decode(stripslashes($entity->conclusion)),
            'plan_depart'          => $entity->plan_depart->name,
            'auditer'              => $entity->auditer,
            'audit_text'           => $entity->audit_text,
            'client_answer_editer' => $entity->client_answer_editer,
            'confirm_editer'       => $entity->confirm_editer,
            'conclusion_editer'    => $entity->conclusion_editer,
            'audit_at'             => $entity->audit_at ? $entity->audit_at->toDateTimeString() : null,
            'answers'              => $entity->answers,
        ];

        return $response;
    }

    public function includeQuestionDetails(PlanDepartQuestion $entity)
    {
        return $this->collection($entity->question_details, new QuestionDetailTransformer());
    }
}
