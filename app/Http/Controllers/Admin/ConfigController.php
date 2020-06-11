<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConfigRequest;
use App\Models\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
  /**
   * @param ConfigRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(ConfigRequest $request)
  {
    $guard_name = $request->input('guard_name');
    $data = Config::where('guard_name', $guard_name)->paginate();
    return $this->setParams($data)->success();
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  {
    $input = $request->only(Config::getFillFields());
    Config::create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = Config::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param Request $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request, $id)
  {
    $input = $request->only(Config::getFillFieldAndExcept(['name']));
    Config::findOrFail($id)->update($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    Config::findOrFail($id)->delete();
    return $this->success();
  }
}
