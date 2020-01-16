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
        $sort = request('sort', 'desc');
        $logs = AdminApiLog::user()->orderBy('id', $sort)->paginate($page);
        return $this->success($logs);
    }
}
