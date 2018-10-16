<?php

namespace App\Containers\Plan\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Plan\Data\Repositories\PlanRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use EasyExcel\Read\ChunkReadFilter;
use EasyExcel\Read\ExcelToArray;
use Exception;

class UploadPlanFromExcelTask extends Task
{

    private $repository;

    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($plan_excel)
    {

        try {

            \DB::beginTransaction();

            //简单获取Excel的数据为Array
            $config = ['firstRowAsIndex' => true];

            $row = 2;
            $plan_data = [
                'name'         => '完整（加工贸易+一般贸易+国内）',
                'is_parent'    => true,
                'plan_departs' => []
            ];

            $plan = Apiato::call('Plan@CreatePlanTask', [$plan_data]);

            //分批获取Excel的数据（防止内存泄漏）
            $chunk = new ChunkReadFilter();
            $chunk->setRows(400, $row);
            $data = new ExcelToArray(public_path() . '\\' . $plan_excel->name, $config);
            $excel_datas = $data->loadByChunk($chunk)->getData();

            /*
             *
             * 获取表格数据
             *
             * 整合所有部门的数据
             *
             * 用于第一次导入方案库数据
             *
             * 或者批量更新基础方案数据
             *
            */
            if (count($excel_datas)) {

                $departs = array_unique(array_pluck($excel_datas, '调查部门'));

                foreach ($departs as $key => $depart) {

                    $departs[$key] = [
                        'name'       => $depart,
                        'icon'       => '',
                        'plan_id'    => $plan->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                }

                \DB::table('plan_departs')->insert($departs);

                foreach ($excel_datas as $key => $value) {

                    $plan_depart = Apiato::call('PlanDepart@FindPlanDepartByNameTask', [$value['调查部门'], $plan->id]);
                    $plan_depart_question = Apiato::call('PlanDepartQuestion@FindPlanDepartQuestionByNameTask', [$value['提问/调查问题'], $plan_depart->id]);

                    if ($plan_depart_question) {

                        $answers = $plan_depart_question->answers;
                        array_push($value['工厂回复'], $answers);

                        $plan_depart_question->update($answers);

                    } else {

                        $questions =
                            [
                                'question'       => $value['提问/调查问题'],
                                'answers'        => '[' . $value['工厂回复'] . ']',
                                'plan_depart_id' => $plan_depart->id,
                                'created_at'     => now(),
                                'updated_at'     => now(),
                            ];

                        \DB::table('plan_depart_questions')->insert($questions);
                    }
                }

            }

            \DB::commit();
            return true;

        } catch (Exception $exception) {
            \DB::rollback();
            throw new UpdateResourceFailedException();
        }
    }
}
