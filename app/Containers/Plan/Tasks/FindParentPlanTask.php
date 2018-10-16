<?php

namespace App\Containers\Plan\Tasks;

use App\Containers\Plan\Models\Plan;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindParentPlanTask extends Task
{
    public function run()
    {
        try {

            return app(Plan::class)->where('is_parent', true)->first();
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
