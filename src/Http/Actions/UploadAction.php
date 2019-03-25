<?php
namespace Chatbox\LaravelUpload\Http\Actions;
use Chatbox\LaravelUpload\Drivers\DriverContract;
use Chatbox\LaravelUpload\UploadContract;
use Chatbox\LaravelUpload\UploadedFile;
use Chatbox\LaravelUpload\Job\UploadJob;
use Chatbox\LaravelUpload\UploadManager;
use Chatbox\LaravelUpload\UploadService;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2019/03/12
 * Time: 15:25
 */

class UploadAction
{
    public function handle(DriverContract $upload)
    {
        $val = $upload->getValidator();
        if($val->fails()){
            throw new ValidationException($val);
        }
        $base64String = $upload->loadBase64String();
        $file = $upload->createFileObject($base64String);
        $upload->storeFile($file);
        dispatch(new UploadJob($file,$base64String,$upload));

        return [
            "file" => $file
        ];
    }



}
