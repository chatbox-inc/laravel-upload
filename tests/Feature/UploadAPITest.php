<?php

namespace Tests\Feature;

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
        assert(data_get($body,"file",false));
        assert(data_get($body,"file.dir") === "default");
        assert(data_get($body,"file.size") === 205356);
        assert(data_get($body,"file.mime") === "image/jpeg");
        assert(data_get($body,"file.url",false) === null);
        assert(data_get($body,"upload",false));
        assert(data_get($body,"upload.status") === "processing");
        assert(data_get($body,"upload.message") === "upload task processing");


        $response = $this->get($this->prefix."/".data_get($body,"file.filename"));
        if($e = $response->baseResponse->exception){
            throw $e;
        }

        $response->assertStatus(200);
        $body = $response->json();
        assert(data_get($body,"file",false));
        assert(data_get($body,"file.dir") === "default");
        assert(data_get($body,"file.size") === 205356);
        assert(data_get($body,"file.mime") === "image/jpeg");
        assert(data_get($body,"file.url",false) !== null);
        assert(data_get($body,"upload",false));
        assert(data_get($body,"upload.status") === "processing");
        assert(data_get($body,"upload.message") === "upload task processing");
    }
}
