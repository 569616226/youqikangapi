<?php

namespace App\Containers\Image\UI\API\Controllers;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Containers\Image\UI\API\Requests\UploadImageRequest;
use App\Ship\Parents\Controllers\ApiController;

/**
 * Class Controller
 *
 * @package App\Containers\Image\UI\API\Controllers
 */
class Controller extends ApiController
{
    /*
    /**
     * @param UpdateImageRequest $request
     * @return array
     */
    public function uploadImage(UploadImageRequest $request)
    {
        return Apiato::call('Image@UploadImageAction', [$request]);

    }


}
