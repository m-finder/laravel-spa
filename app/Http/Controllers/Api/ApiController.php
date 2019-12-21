<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    /**
     * json 返回
     * @param null $data
     * @param string $msg
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null)
    {
        return response()->json($data, Response::HTTP_OK);
    }

    protected function error($msg = null)
    {
        return response()->json([
            'message' => $msg ? $msg : '操作失败'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
