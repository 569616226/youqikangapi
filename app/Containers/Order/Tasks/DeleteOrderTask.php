<?php

namespace App\Containers\Order\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Order\Data\Repositories\OrderRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteOrderTask extends Task
{

    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {
        try {

            $order = Apiato::call('Order@FindOrderByIdTask', [$id]);

            if ($order->status == '未开始') {

                $result = $this->repository->delete($id);

                if ($result) {

                    return success_simple_respone('订单删除成功');

                } else {

                    return error_simple_respone();

                }

            } else {

                return error_simple_respone('不能删除' . $order->status . '的订单');

            }
        } catch (Exception $exception) {

            throw new DeleteResourceFailedException();

        }
    }
}
