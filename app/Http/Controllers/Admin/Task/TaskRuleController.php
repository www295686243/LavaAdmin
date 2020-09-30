<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Task\TaskRuleRequest;
use App\Models\Task\TaskRule;
use Illuminate\Http\Request;

class TaskRuleController extends Controller
{
  /**
   * @param TaskRuleRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(TaskRuleRequest $request)
  {
    $task_id = $request->input('task_id');
    $data = TaskRule::where('task_id', $task_id)
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param TaskRuleRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(TaskRuleRequest $request)
  {
    $input = $request->only(TaskRule::getFillFields());
    TaskRule::create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = TaskRule::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param TaskRuleRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(TaskRuleRequest $request, $id)
  {
    $input = $request->only(TaskRule::getFillFields());
    $data = TaskRule::findOrFail($id);
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
    $data = TaskRule::findOrFail($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}
