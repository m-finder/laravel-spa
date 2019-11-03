<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    const ERROR_NONE = 0;
    const ERROR_SYSTEM_INTERRUPTED = 300;
    const ERROR_USER_NOT_EXIST = 301;
    const ERROR_PARAMS = 302;



    const MSG_TYPE_SUCCESS = "success";
    const MSG_TYPE_INFO = "info";
    const MSG_TYPE_WARNING = "warning";
    const MSG_TYPE_ERROR = "danger";

    /**
     * json 返回
     * @param null $data
     * @param string $msg
     * @param int $code
     * @param string $msg_type
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json_response($data = null, $msg = "操作成功。", $code = self::ERROR_NONE, $msg_type = self::MSG_TYPE_INFO) {
        return response()->json(["code" => $code, "msg" => $msg, "msg_type" => $msg_type, "data" => $data]);
    }
}
