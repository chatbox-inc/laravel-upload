<?php
namespace Chatbox\LaravelUpload\Drivers;
use Chatbox\LaravelUpload\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2019/03/13
 * Time: 17:30
 */

class CacheDriver implements DriverContract
{
    protected $requestKey;
    protected $rules;
    protected $dir;

    protected $cacheKey;
    protected $cacheLifespan;

    /**
     * CacheDriver constructor.
     * @param $requestKey
     * @param $rules
     */
    public function __construct(array $config=[])
    {
        $this->requestKey = Arr::get($config,"request_key","file");
        $this->rules = Arr::get($config,"validation_rules",[
            $this->requestKey => ["required","min:100"]
        ]);
        $this->dir = Arr::get($config,"dest_dir","default");
        $this->cacheKey = Arr::get($config,"cacheKey","UPLOAD.CACHE");
        $this->cacheLifespan = Arr::get($config,"cacheLifespan",60*5);
    }


    public function getValidator(): Validator{
        $val = validator(request()->all(), $this->rules);
        return $val;
    }

    /**
     * Retrieve File Data
     * @inheritdoc
     */
    public function loadBase64String(){

        $data = request()->all();
        $image = Arr::get($data, $this->requestKey);
        return $image;
    }

    public function createFileObject($base64string): UploadedFile
    {
        $data = base64_decode($base64string);
        $mimeType = finfo_buffer(finfo_open(), $data, \FILEINFO_MIME_TYPE);

        $file = new UploadedFile();
        $file->filename = Str::random();
        $file->dir = $this->dir;
        $file->mime = $mimeType;
        $file->size = strlen($data);
        return $file;
    }

    public function getFileByName($name):?UploadedFile
    {
        return Cache::get($this->cacheKey.$name);
    }

    public function storeFile(UploadedFile $file)
    {
        Cache::put($this->cacheKey.$file->filename,$file,$this->cacheLifespan);
    }

    public function setUrl(UploadedFile $file, $url)
    {
        $file->url = $url;
        Cache::put($this->cacheKey.$file->filename,$file,$this->cacheLifespan);
    }


}
