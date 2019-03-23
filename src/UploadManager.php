<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2019/03/13
 * Time: 17:25
 */

namespace Chatbox\LaravelUpload;

use Chatbox\LaravelUpload\Drivers\CacheDriver;
use Chatbox\LaravelUpload\Drivers\DriverContract;
use Illuminate\Support\Manager;

class UploadManager extends Manager
{
    protected $active;

    public function setActive($name){
        $this->active = $name;
    }

    public function getActiveDriver(): DriverContract
    {
        return $this->driver($this->active);
    }

    public function getDefaultDriver()
    {
        throw new \Exception("default driver not implemented");
    }

    public function createCacheDriver(){
        $driver = new CacheDriver();
        return $driver;
    }

    public function createDatabaseDriver(){
        $driver = new CacheDriver();
        return $driver;
    }


}
