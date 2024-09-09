<?php

namespace App\Helper;

class ResponseHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $status string
     * @param $message string
     * @param $data array
     * @param $statusCode integer
     * @return mixed
     * Function : Common function to display success - Json Response
     */
    public static function success($status = 'success', $message = null, $data = [], $statusCode = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ],
            $statusCode
        );
    }

    /**
     * @param $status string
     * @param $message string
     * @param $statusCode integer
     * @return mixed
     * Function : Common function to display error - Json Response
     */
    public static function error($status = 'error', $message = null, $statusCode = 400)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ],
            $statusCode
        );
    }
}
