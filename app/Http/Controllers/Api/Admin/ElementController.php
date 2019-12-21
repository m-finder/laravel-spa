<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Element;
use Illuminate\Support\Facades\Log;


class ElementController extends ApiController
{

    public function lists()
    {
        $page = request('limit', 20);
        $elements = Element::menuId()->paginate($page);
        return $this->success($elements);
    }

    public function detail($id)
    {
        $detail = Element::findOrFail($id);
        return $this->success($detail);
    }

    public function create()
    {
        $model = new Element();
        if (Element::checkUnique()) {
            $model->create(request_intersect([
                'menu_id', 'name', 'code', 'method', 'path',
            ]));
        } else {
            return $this->error('该资源已存在');
        }
        return $this->success();
    }

    public function update($id)
    {
        $element = Element::findOrFail($id);
        if (Element::checkUnique()) {
            $element->update(request_intersect([
                'name', 'code', 'method', 'path',
            ]));
        } else {
            return $this->error('该资源已存在');
        }

        return $this->success();
    }

    public function delete($id)
    {
        $element = Element::findOrFail($id);
        $element->delete();
        return $this->success();
    }
}
