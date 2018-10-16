<?php

namespace App\Containers\ReportDepart\UI\API\Transformers;

use App\Containers\ReportDepart\Models\ReportDepart;
use App\Containers\ReportDepartQuestion\UI\API\Transformers\ReportDepartQuestionTransformer;
use App\Ship\Parents\Transformers\Transformer;

/**
 * Class ReportDepartTransformer
 * @package App\Containers\ReportDepart\UI\API\Transformers
 */
class ReportDepartTransformer extends Transformer
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
        'report_depart_questions'
    ];

    /**
     * @param ReportDepart $entity
     *
     * @return array
     */
    public function transform(ReportDepart $entity)
    {

        $report_depart_questions = $entity->report_depart_questions;

        $nomarls = $report_depart_questions->filter(function ($item) {
            return $item->conclusion_status == '合格';
        });

        $errors = $report_depart_questions->filter(function ($item) {
            return $item->conclusion_status !== '合格';
        });

        $generals = $report_depart_questions->filter(function ($item) {
            return $item->conclusion_status == '一般';
        });

        $middles = $report_depart_questions->filter(function ($item) {
            return $item->conclusion_status == '中等';
        });

        $hights = $report_depart_questions->filter(function ($item) {
            return $item->conclusion_status == '偏高';
        });

        $serious = $report_depart_questions->filter(function ($item) {
            return $item->conclusion_status == '严重';
        });

        $counts = $report_depart_questions->count();
        $nomarl_counts = $nomarls->count();
        $error_counts = $errors->count();
        $general_counts = $generals->count();
        $middle_counts = $middles->count();
        $hight_counts = $hights->count();
        $serious_counts = $serious->count();

        $type = [
            [
                'id'      => 'serious',
                'memo'    => '严重',
                'namekey' => 'namekey',
                'amount'  => $serious_counts,
                'ratio'   => $serious_counts,
            ], [
                'id'      => 'highside',
                'memo'    => '偏高',
                'namekey' => 'namekey',
                'amount'  => $hight_counts,
                'ratio'   => $hight_counts,
            ], [
                'id'      => 'middle',
                'memo'    => '中等',
                'namekey' => 'namekey',
                'amount'  => $middle_counts,
                'ratio'   => $middle_counts,
            ], [
                'id'      => 'commonly',
                'memo'    => '一般',
                'namekey' => 'namekey',
                'amount'  => $general_counts,
                'ratio'   => $general_counts,
            ]
        ];


        $general_questions = $this->get_question_data($generals->toArray());
        $middle_questions = $this->get_question_data($middles->toArray());
        $hight_questions = $this->get_question_data($hights->toArray());
        $serious_questions = $this->get_question_data($serious->toArray());
        $nomarl_questions = $this->get_question_data($nomarls->toArray());

        $response = [
            'object'            => 'ReportDepart',
            'id'                => $entity->getHashedKey(),
            'name'              => $entity->name,
            'icon'              => $entity->icon,
            'counts'            => $counts,
            'error_counts'      => $error_counts,
            'general_counts'    => $general_counts,
            'middle_counts'     => $middle_counts,
            'hight_counts'      => $hight_counts,
            'serious_counts'    => $serious_counts,
            'nomarl_counts'     => $nomarl_counts,
            'type'              => $type,
            'general_questions' => $general_questions,
            'middle_questions'  => $middle_questions,
            'hight_questions'   => $hight_questions,
            'serious_questions' => $serious_questions,
            'nomarl_questions'  => $nomarl_questions,
            'created_at'        => $entity->created_at->toDateTimeString(),
        ];

        return $response;
    }

    /**
     * @param ReportDepart $entity
     * @return \League\Fractal\Resource\Collection
     */
    public function includeReportDepartQuestions(ReportDepart $entity)
    {
        return $this->collection($entity->report_depart_questions, new ReportDepartQuestionTransformer());
    }


    /**
     * 格式化问题数据
     * client_answer =》　question
     *
     * @param array $datas
     * @return mixed
     */
    protected function get_question_data(array $datas)
    {
        if(count($datas)){

            $filter_datas = [];
            foreach ($datas as $key => $data) {

                $data = array_only($data, ['client_answer', 'question']);
                $filter_data['client_answer'] = $data['client_answer'];
                $filter_data['question'] = $data['question'];
                array_push($filter_datas,$filter_data);
            }

            return $filter_datas;

        }else{

           return null;

        }


    }
}
