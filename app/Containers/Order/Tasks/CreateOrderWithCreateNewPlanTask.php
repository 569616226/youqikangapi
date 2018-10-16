<?php

namespace App\Containers\Order\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Order\Data\Repositories\OrderRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class CreateOrderWithCreateNewPlanTask extends Task
{

    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(array $data, array $plan_data)
    {
        try {

            \DB::beginTransaction();

            $plan = Apiato::call('Plan@CreatePlanTask', [$plan_data]);

            if ($plan) {

                $data['plan_id'] = $plan->id;

                $order = $this->repository->create($data);

                \DB::commit();

                return $order;

            } else {

                \DB::rollback();

                return false;

            }

        } catch (Exception $exception) {

            \DB::rollback();
            throw new CreateResourceFailedException();

        }
    }
}
