<?php

namespace App\Containers\Order\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Order\Data\Repositories\OrderRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UpdateOrderTask extends Task
{

    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id, array $data)
    {
        try {

            return $this->repository->update($data, $id);

        } catch (Exception $exception) {

            throw new UpdateResourceFailedException();
        }
    }
}
