<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfigTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $config = config("upload");
        $defaultConfig = $this->getTestConfig();
        $this->assertEquals($config,$defaultConfig);
    }
}
