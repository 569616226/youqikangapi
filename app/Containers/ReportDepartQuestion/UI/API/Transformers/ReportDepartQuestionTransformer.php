<?php

namespace App\Containers\ReportDepartQuestion\UI\API\Transformers;

use App\Containers\ReportDepartQuestion\Models\ReportDepartQuestion;
use App\Ship\Parents\Transformers\Transformer;

class ReportDepartQuestionTransformer extends Transformer
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
     * @param ReportDepartQuestion $entity
     *
     * @return array
     */
    public function transform(ReportDepartQuestion $entity)
    {
        $response = [
            'object'               => 'ReportDepartQuestion',
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
            'report_depart'        => $entity->report_depart->name,
            'auditer'              => $entity->auditer,
            'audit_text'           => $entity->audit_text,
            'client_answer_editer' => $entity->client_answer_editer,
            'confirm_editer'       => $entity->confirm_editer,
            'conclusion_editer'    => $entity->conclusion_editer,
            'audit_at'             => $entity->audit_at ? $entity->audit_at->toDateTimeString() : null,
        ];

        return $response;
    }
}
