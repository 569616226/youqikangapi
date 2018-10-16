<?php

namespace App\Containers\Image\Actions;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class UploadImageAction extends Action
{
    public function run(Request $request)
    {

        $image = Apiato::call('Image@UploadImageTask', [$request]);

        return $image;
    }
}
