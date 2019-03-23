<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2019/03/12
 * Time: 20:17
 */

namespace Chatbox\LaravelUpload\Job;


use Chatbox\LaravelUpload\Drivers\DriverContract;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Chatbox\LaravelUpload\UploadedFile;

class UploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uploadedFile;

    protected $fileData;

    protected $upload;

    /**
     * UploadJob constructor.
     * @param $upload
     * @param $uploadedFile
     */
    public function __construct(UploadedFile $uploadedFile, $base64String,DriverContract $driver)
    {
        $this->fileData = $base64String;
        $this->uploadedFile = $uploadedFile;
        $this->upload = $driver;
    }

    public function handle()
    {
        $path = $this->getPath();
        Storage::put($path, $this->getFiledata());
        $url = Storage::url($path);
        $this->upload->setUrl($this->uploadedFile,$url);
    }

    protected function getPath(){
        $path = $this->uploadedFile->dir. "/" . $this->uploadedFile->filename;
        return $path;
    }

    protected function getFiledata(){
        return base64_decode($this->fileData);
    }


}
