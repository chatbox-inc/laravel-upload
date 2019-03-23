<?php
namespace Chatbox\LaravelUpload;

use Chatbox\LaravelUpload\Drivers\DriverContract;
use Illuminate\Support\ServiceProvider;
use Chatbox\LaravelUpload\Providers\RouteServiceProvider;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/12/19
 * Time: 0:09
 */

class LaravelUploadServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        $this->loadMigrationsFrom(__DIR__.'/path/to/migrations');
        $this->mergeConfigFrom(
            __DIR__.'/../config/upload.php', 'upload'
        );
    }

    public function register()
    {
        $this->app->singleton(UploadManager::class, function ($app) {
            return new UploadManager($app);
        });
        $this->app->bind(DriverContract::class, function ($app) {
            /** @var UploadManager $manager */
            $manager = app(UploadManager::class);
            return $manager->getActiveDriver();
        });
        $this->app->register(RouteServiceProvider::class);
    }

}
