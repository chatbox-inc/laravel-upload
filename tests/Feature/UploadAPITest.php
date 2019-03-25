<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadAPITest extends TestCase
{
    protected $prefix = "api/image/test/cache";

    public function testアップロードルート()
    {
        $response = $this->post($this->prefix,[
            "file" => base64_encode(file_get_contents(__DIR__."/../_files/sample.jpg"))
        ]);

        if($e = $response->baseResponse->exception){
            throw $e;
        }

        $response->assertStatus(200);

        $body = $response->json();
        $this->assertIsArray($response->json("file"));
        $this->assertEquals($response->json("file.dir"), "default".Carbon::now()->format("/Y/m/d/"));
        $this->assertEquals($response->json("file.size"), 205356);
        $this->assertEquals($response->json("file.mime"), "image/jpeg");
        $this->assertEquals($response->json("file.url"), null);


        $response = $this->get($this->prefix."/".data_get($body,"file.filename"));
        $response->assertStatus(200);
        $this->assertIsArray($response->json("file"));
        $this->assertEquals($response->json("file.dir"), "default".Carbon::now()->format("/Y/m/d/"));
        $this->assertEquals($response->json("file.size"), 205356);
        $this->assertEquals($response->json("file.mime"), "image/jpeg");
        $this->assertTrue(!!$response->json("file.url"));
    }
}
