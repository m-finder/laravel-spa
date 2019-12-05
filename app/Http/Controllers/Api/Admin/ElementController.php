<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Element;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElementController extends ApiController
{
    public function lists() {
        $elements = Element::routerId(request('router_id'))->paginate(10);
        return $this->json_response($elements);
    }
}
