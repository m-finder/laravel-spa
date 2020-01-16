<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\AdminApiLog;
use Illuminate\Http\Request;

class AdminApiLogController extends ApiController
{
    public function lists()
    {
        $page = request('limit', 20);
        $logs = AdminApiLog::user()->orderBy('id', 'desc')->paginate($page);
        return $this->success($logs);
    }
}
