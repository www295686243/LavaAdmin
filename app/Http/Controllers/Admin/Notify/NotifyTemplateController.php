<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotifyTemplateRequest;
use App\Models\Notify\NotifyTemplate;
use Illuminate\Http\Request;

class NotifyTemplateController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = NotifyTemplate::orderByDesc('id')->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param NotifyTemplateRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(NotifyTemplateRequest $request)
  {
    $input = $request->only(NotifyTemplate::getFillFields());
    NotifyTemplate::create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = NotifyTemplate::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param NotifyTemplateRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(NotifyTemplateRequest $request, $id)
  {
    $input = $request->only(NotifyTemplate::getFillFields());
    $data = NotifyTemplate::findOrFail($id);
    $data->update($input);
    return $this->success();
  }
}
