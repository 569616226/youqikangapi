<?php

namespace App\Containers\Image\Tasks;

use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Tasks\Task;
use Exception;

class UploadImageTask extends Task
{

    public function run(Request $request)
    {
        try {

            /*增加文件夹权限*/
            $images_path = storage_path() . '/app/public/images';
            if (!is_dir($images_path)) {
                mkdir($images_path, 0777, true);
            }

            $path = $request->file('image')->store('/images', 'public');

            if ($path) {

                /*修改图片权限*/
                chmod(storage_path() . '/app/public/' . $path, 0777);

                return response()->json(['status' => true, 'url' => env('APP_URL') . '/storage/' . $path]);

            } else {

                return error_simple_respone();

            }
        } catch (Exception $exception) {

            report($exception);
            throw new UpdateResourceFailedException();

        }
    }
}
