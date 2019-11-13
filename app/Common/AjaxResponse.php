<?php
namespace App\Common;

class AjaxResponse extends \stdClass{
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 0;

    public $status = self::STATUS_SUCCESS;
    public $message;


    public static function response($message, $status = self::STATUS_ERROR, $extras = []) {
        //return array_merge_recursive(['status'=>$status,'message'=>$message], $extras);
        return array_merge(['status'=>$status,'message'=>$message], $extras);
    }

	public static function responseSuccess($message, $extras = []) {
		return self::response($message, self::STATUS_SUCCESS, $extras);
	}

	public static function responseError($message, $extras = []) {
		return self::response($message, self::STATUS_ERROR, $extras);
	}

    public static function badRequest() {
        return self::response('Bad Request');
    }
}