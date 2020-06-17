<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConfigOptionRequest;
use App\Models\ConfigOption;
use Illuminate\Http\Request;

class ConfigOptionController extends Controller
{
  /**
   * @param ConfigOptionRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(ConfigOptionRequest $request)
  {
    $config_id = $request->input('config_id');
    $data = ConfigOption::when($config_id, function ($query, $config_id) {
      return $query->where('config_id', $config_id);
    })
      ->orderBy('sort', 'asc')
      ->orderBy('id', 'asc')
      ->paginate();
    return $this->setParams($data)->success();
  }

  /**
   * @param ConfigOptionRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(ConfigOptionRequest $request)
  {
    $input = $request->only(ConfigOption::getFillFields());
    ConfigOption::create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = ConfigOption::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param ConfigOptionRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(ConfigOptionRequest $request, $id)
  {
    $input = $request->only(ConfigOption::getFillFieldAndExcept('config_id'));
    $data = ConfigOption::findOrFail($id);
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
    $data = ConfigOption::findOrFail($id);
    $data->delete();
    return $this->success();
  }
}
