<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Element;


class ElementController extends ApiController {

    public function lists() {
        $elements = Element::routerId(request('router_id'))->paginate(10);
        return $this->json_response($elements);
    }

    public function detail($id) {
        if (is_null($id)) {
            return $this->json_response(null, '参数错误', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
        }
        $detail = Element::find($id);
        return $this->json_response($detail);
    }

    public function create() {
        $model = new Element();
        try {
            if (Element::checkUnique()) {
                $model->create(request_intersect([
                    'router_id', 'name', 'code', 'method', 'path',
                ]));
            } else {
                return $this->json_response(null, '该资源已存在', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function update($id) {
        $element = Element::where('id', $id)->first();
        try {
            if (is_null($element)) {
                return $this->json_response(null, '资源不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
            }
            if (Element::checkUnique()) {
                $element->update(request_intersect([
                   'name', 'code', 'method', 'path',
                ]));
            } else {
                return $this->json_response(null, '该资源已存在', self::ERROR_PARAMS, self::MSG_TYPE_ERROR);
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return $this->json_response(null, '系统错误', self::ERROR_SYSTEM_INTERRUPTED, self::MSG_TYPE_ERROR);
        }
        return $this->json_response();
    }

    public function delete($id) {
        $element = Element::find($id);
        if (is_null($element)) {
            return $this->json_response(null, '资源不存在', self::ERROR_USER_NOT_EXIST, self::MSG_TYPE_ERROR);
        } else {
            $element->delete();
            return $this->json_response();
        }
    }
}
