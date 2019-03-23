<?php
namespace Chatbox\LaravelUpload\Http\Middleware;
use Chatbox\LaravelUpload\UploadManager;
use Illuminate\Validation\ValidationException;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2019/03/13
 * Time: 18:30
 */

class UploadDriver
{
    protected $upload;

    /**
     * UploadDriver constructor.
     * @param $upload
     */
    public function __construct(UploadManager $upload)
    {
        $this->upload = $upload;
    }


    /**
     * @param $request
     * @param $next
     * @param $driver
     * @return mixed
     * @throws ValidationException
     */
    public function handle($request,$next,$driver){
        $this->upload->setActive($driver);
        return $next($request);
    }
}
