<?php

namespace App\Containers\Report\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\PlanDepartQuestion\Models\PlanDepartQuestion;
use App\Containers\QuestionDetail\Models\QuestionDetail;
use App\Containers\Report\Data\Repositories\ReportRepository;
use App\Containers\Report\Events\ReportEvent;
use App\Containers\ReportDepartQuestion\Models\ReportDepartQuestion;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateReportTask extends Task
{

    private $repository;

    public function __construct(ReportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {

            \DB::beginTransaction();

            $order = Apiato::call('Order@FindOrderByIdTask', [$id]);

            $data = [
                'name'     => $order->company->name . now()->year . '年诊断报告',
                'order_id' => $id,
            ];

            $departs = $order->plan->plan_departs;

            $report = $this->repository->create($data);

            /*插入报告部门*/
            $report_departs = [];
            foreach ($departs as $depart_key => $depart) {
                $report_departs[$depart_key] = collect($depart->toArray())->except([
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'plan_id'
                ])->all();

                $report_departs[$depart_key]['report_id'] = $report->id;
                $report_departs[$depart_key]['created_at'] = now();
                $report_departs[$depart_key]['updated_at'] = now();
            }

            \DB::table('report_departs')->insert($report_departs);

            /*
             * 插入报告问题
             * */
            $report_depart_questions = [];
            $plan_depart_ids = $departs->pluck('id')->toArray();
            $plan_depart_questions = PlanDepartQuestion::whereIn('plan_depart_id', $plan_depart_ids)->get();

            foreach ($plan_depart_questions as $key => $plan_depart_question) {

                $report_depart_questions[$key] = collect($plan_depart_question->toArray())->except([
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'plan_depart_id'

                ])->all();

                /*
                 * 格式化进一步提问数据
                 *
                 * 将数组格式化为字符
                */
                $filter_question_details = '[';
                $question_details = QuestionDetail::where('plan_depart_question_id', $plan_depart_question['id'])->get();

                foreach ($question_details as $detail_key => $question_detail) {

                    $filter_question_details .= '["' . $question_detail->question . '","' . $question_detail->answer . '"],';

                }

                $filter_question_details .= ']';

                $report_depart_questions[$key]['answers'] = '[' . implode(',', $plan_depart_question->answers) . ']';
                $report_depart_questions[$key]['status'] = $report_depart_questions[$key]['status'] ?? '未开始';
                $plan_depart_question_more_files = $plan_depart_question->more_files ? '[' . implode(',', $plan_depart_question->more_files) . ']' : '[]';
                $report_depart_questions[$key]['more_files'] = $plan_depart_question_more_files;
                $report_depart_questions[$key]['question_details'] = $filter_question_details;
                $report_depart_questions[$key]['report_depart_id'] = $plan_depart_question->plan_depart_id;
                //        $report_depart_questions[$key]['created_at'] = now();
                //        $report_depart_questions[$key]['updated_at'] = now();

            }

            foreach ($report_depart_questions as $report_depart_question) {
                App(ReportDepartQuestion::class)->create($report_depart_question);
            }

            /*一次性插入太多数据，mysql报错*/
            //      \DB::table('report_depart_questions')->insert($report_depart_questions);

            $is_client_admin = $report->order->company->users()->where('is_client_admin', 1)->get();

            /*
             * 发送模板消息
             *
             * 如果没有设置企业主
             *
            */


            if (config('comm.send_report_event') && !$is_client_admin->isEmpty() && $is_client_admin->first()->open_id) {

                \App::make(\Illuminate\Contracts\Bus\Dispatcher::class)
                    ->dispatch(new ReportEvent($report));
            }

           $order =  Apiato::call('Order@UpdateOrderTask', [
                $order->id,
                ['status' => '已完成']
            ]);

            \DB::commit();

            if ($report && $order->status == '已完成') {

                \DB::commit();
                return success_simple_respone($report->name . '生成成功');

            } else {

                \DB::rollback();
                return error_simple_respone();

            }


        } catch (Exception $exception) {

            \DB::rollback();
            report($exception);
            throw new CreateResourceFailedException();

        }
    }
}
