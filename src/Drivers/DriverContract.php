<?php
namespace Chatbox\LaravelUpload\Drivers;
use Chatbox\LaravelUpload\UploadedFile;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2019/03/13
 * Time: 17:30
 */

interface DriverContract
{

    /**
     * @return Validator
     */
    public function getValidator():Validator;
    /**
     * @throws ValidationException
     * @return string
     */
    public function loadBase64String();

    /**
     * リクエストからファイルオブジェクトを取得
     */
    public function createFileObject($base64String):UploadedFile;

    /**
     * 問い合わせ時に ファイルオブジェクトを取得
     * @param $name
     * @return mixed
     */
    public function getFileByName($name):?UploadedFile;

    /**
     * @param UploadedFile $file
     * @return mixed
     */
    public function storeFile(UploadedFile $file);

    /**
     *
     * @param UploadedFile $file
     * @param $url
     * @return mixed
     */
    public function setUrl(UploadedFile $file,$url);

}
