<?php

namespace App\Containers\Welcome\Tasks;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class HomePageTask extends Task
{

    public function run()
    {
        try {

            $orders = Apiato::call('Order@GetAllOrdersTask', [true]);
            $companies = Apiato::call('Company@GetAllCompaniesTask', [true]);
            $clients = Apiato::call('User@GetAllUsersTask', [true], [
                'clients'
            ]);

            return response()->json([
                'data' => [
                    'orders'    => $orders->count(),
                    'companies' => $companies->count(),
                    'clients'   => $clients->count(),
                ]
            ]);
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
