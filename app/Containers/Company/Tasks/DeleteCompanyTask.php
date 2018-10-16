<?php

namespace App\Containers\Company\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Company\Data\Repositories\CompanyRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteCompanyTask extends Task
{

    private $repository;

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {

            \DB::beginTransaction();

            $company = Apiato::call('Company@FindCompanyByIdTask', [$id]);

            $order_status = array_unique($company->orders->pluck('status')->toArray());

            /*是否可以删除*/
            $is_del = true;
            if (count($order_status)) {

                $is_del = count($order_status) == 1 && $order_status[0] == '未开始';

            }

            if ($is_del) {

                $company->orders()->delete();//删除所有订单
                $company->users()->detach();

                $result = $this->repository->delete($id);
                if ($result) {

                    \DB::commit();
                    return success_simple_respone('客户删除成功');

                } else {

                    \DB::rollback();
                    return error_simple_respone();
                }

            } else {

                \DB::rollback();
                return error_simple_respone('不能删除有订单项目在进行的客户');

            }

        } catch (Exception $exception) {

            \DB::rollback();
            throw new DeleteResourceFailedException();
        }
    }
}
