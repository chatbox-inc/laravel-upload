<?php

namespace Tests;

use Chatbox\LaravelUpload\LaravelUploadServiceProvider;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var Application $app */
        $app = require __DIR__.'/../laravel.php';
        $app->make(Kernel::class)->bootstrap();
        config()->set("upload",$this->getTestConfig());
        $app->register(LaravelUploadServiceProvider::class);
        return $app;
    }

    protected function getTestConfig(){
        return [
            "routes" => [
                [
                    "prefix" => "api/image/test/cache",
                    "driver" => "cache",
                    "middleware" => ["api"]
                ],
                [
                    "prefix" => "api/image/test/database",
                    "driver" => "database",
                    "middleware" => ["api"]
                ],
            ],
            "drivers" => [
                "cache" => [
                    "driver" => "cache",
                    "options" => []
                ],
                "database" => [
                    "driver" => "database",
                    "options" => []
                ]
            ]
        ];
    }
}
