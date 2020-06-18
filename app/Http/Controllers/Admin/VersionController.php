<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VersionRequest;
use App\Models\Version;

class VersionController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = Version::all();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = Version::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param VersionRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(VersionRequest $request, $id)
  {
    $input = $request->only(Version::getFillFieldAndExcept(['name']));
    $data = Version::findOrFail($id);
    $data->update($input);
    return $this->success();
  }
}
