<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\IndustryRequest;
use App\Models\Info\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = Industry::all()->toTree();
    return $this->setParams($data)->success();
  }

  /**
   * @param IndustryRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(IndustryRequest $request)
  {
    $input = $request->only(Industry::getFillFields());
    $data = Industry::where('display_name', $input['display_name'])->first();
    if ($data) {
      return $this->error('已经添加过了');
    }
    Industry::create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = Industry::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param IndustryRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(IndustryRequest $request, $id)
  {
    $input = $request->only(Industry::getFillFields());
    $data = Industry::findOrFail($id);
    $data->update($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $data = Industry::findOrFail($id);
    return $data->delete() ? $this->success() : $this->error();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getParentTree()
  {
    $data = Industry::withDepth()->having('depth', '<', 3)->get()->toTree();
    return $this->setParams($data)->success();
  }
}
