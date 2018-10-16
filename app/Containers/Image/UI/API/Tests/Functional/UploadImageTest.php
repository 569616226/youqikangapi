<?php

namespace App\Containers\Image\UI\API\Tests\Functional;

use App\Containers\Image\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class UpdateImageTest.
 *
 * @author Mahmoud Zalt <mahmoud@zalt.me>
 */
class UploadImageTest extends TestCase
{

    protected $endpoint = 'post@v1/upload_image';

    protected $access = [
        'roles'       => '',
        'permissions' => '',
    ];

    public function testUpdateExistingImage_()
    {

        Storage::fake('images');
        $data = [
            'image' => UploadedFile::fake()->image('image.jpg')
        ];

        // send the HTTP request
        $response = $this->makeCall($data);

        // assert response status is correct
        $response->assertStatus(200);

        // assert returned user is the updated one
        $this->assertResponseContainKeys([
            'status',
            'url',
        ]);

        $responseContent = $this->getResponseContentObject();

        $image_urls = explode('/', $responseContent->url);
        $image_name = $image_urls[count($image_urls) - 1];

        Storage::disk('public')->assertExists('/images/' . $image_name);

    }


}


