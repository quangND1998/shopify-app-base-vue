<?php

namespace App\Traits;



trait ResponseHandler
{

    protected function successResponse($data)
    {

        $response = array_merge([
            'code' => 200,
            'status' => 'success',
        ], ['data' => $data]);
        return response()->json($response, 200);
    }

    protected function notFoundResponse()
    {
        $response = [
            'code' => 404,
            'status' => 'error',
            'data' => 'Resource Not Found',
            'message' => 'Not Found'
        ];
        return response()->json($response, $response['code']);
    }

    public function deleteResponse()
    {
        $response = [
            'code' => 200,
            'status' => 'success',
            'data' => [],
            'message' => 'Resource Deleted'
        ];
        return response()->json($response, $response['code']);
    }

    public function errorResponse($data)
    {
        $response = [
            'code' => 422,
            'status' => 'error',
            'data' => $data,
            'message' => 'Unprocessable Entity'
        ];
        return response()->json($response, $response['code']);
    }

    public function paymentRequiredResponse($message)
    {
        $response = [
            'code' => 402,
            'status' => 'error',
            'data' => 'payment required',
            'message' => $message
        ];
        return response()->json($response, $response['code']);
    }
}
