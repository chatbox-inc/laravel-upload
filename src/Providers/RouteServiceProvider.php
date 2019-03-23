<?php
namespace Chatbox\LaravelUpload\Providers;

use Chatbox\LaravelUpload\Http\Actions\DetailAction;
use Chatbox\LaravelUpload\Http\Actions\UploadAction;
use Chatbox\LaravelUpload\Http\Middleware\UploadDriver;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Arr;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        /** @var Router $router */
        $router = app(Router::class);
        $router->aliasMiddleware("upload",UploadDriver::class);
    }

    public function map()
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes()
    {
        $uploadConfig = config("upload");

        foreach ( Arr::get($uploadConfig, "routes", []) as $routeConfig) {
            $prefix = Arr::get($routeConfig,"prefix","");
            $middleware = Arr::get($routeConfig,"middleware",[]);
            $middleware[] = "upload:".Arr::get($routeConfig,"driver","");
            Route::prefix($prefix)
                ->middleware($middleware)
                ->group(function($route){
                    $route->get("/{name}",DetailAction::class."@handle");
                    $route->post("/",UploadAction::class."@handle");
                });
        }

    }
}
