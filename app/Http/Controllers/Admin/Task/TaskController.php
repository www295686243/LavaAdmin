<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Task\TaskRequest;
use App\Models\Task\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function indexAll() {
    $data = Task::orderByDesc('id')->get();
    return $this->setParams($data)->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = Task::orderByDesc('id')->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param TaskRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(TaskRequest $request)
  {
    $input = $request->only(Task::getFillFields());
    Task::create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = Task::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param TaskRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(TaskRequest $request, $id)
  {
    $input = $request->only(Task::getFillFields());
    $data = Task::findOrFail($id);
    $data->update($input);
    return $this->success();
  }
}
