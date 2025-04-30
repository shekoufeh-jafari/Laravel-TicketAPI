<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponse
{

    protected function ok($message, $data = [])
    {
        return $this->success($message, $data, 200);
    }

    protected function success($message, $data = [], $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode
        ], $statusCode);
    }

    protected function error($errors = [], $statusCode = null)
    {
        if (is_string($errors)) {
            return response()->json([
                'message' => $errors,
                'status' => $statusCode
            ], $statusCode);
        }

        return Response()->json([
            'errors'=> $errors
            
        ]);
    }


    protected function notAuthorized($message){
        return $this->error([
            'status' => 401,
            'message' => $message,
            'source' => ''
            
        ]);
    }
}
