<?php

namespace App\Common;

class Response
{
    public static function success($message = 'Success', $data = [])
    {
        return response()->json([
            'status' => HttpStatusCode::HTTP_OK,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function error($code, $message = '', $data = [])
    {
        $message = empty($message) ? HttpStatusCode::getMessageForCode($code) : $message;

        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}