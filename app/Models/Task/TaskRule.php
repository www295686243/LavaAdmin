<?php

namespace App\Models\Task;

use App\Models\Api\User;
use App\Models\Base;
use Illuminate\Support\Facades\Cache;

class TaskRule extends Base
{
  protected $fillable = [
    'task_id',
    'title',
    'get_number',
    'rules',
    'rewards'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'rules' => 'array',
    'rewards' => 'array',
    'task_id' => 'string'
  ];

  /**
   * @param $value
   * @return array|mixed
   */
  public function getRulesAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @param $value
   * @return array|mixed
   */
  public function getRewardsAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  /**
   * @return TaskRecord|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
   */
  public function getRecordData()
  {
    if ($this->id === $this->getValue(1, '个人资料修改')) {
      return $this->_getRecordData(User::getUserId());
    }
    return null;
  }

  /**
   * @param $user_id
   * @return TaskRecord|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
   */
  private function _getRecordData($user_id)
  {
    if (!$user_id) {
      $this->error('taskRule：用户id不能为空');
    }
    $recordData = TaskRecord::where('task_rule_id', $this->id)
      ->where('user_id', $user_id)
      ->first();
    if (!$recordData) {
      $recordData = TaskRecord::create([
        'task_rule_id' => $this->id,
        'task_id' => $this->task_id,
        'user_id' => $user_id
      ]);
    }
    return $recordData;
  }

  private function getValue($id, $display_name) {
    $list = $this->getCacheAllList();
    $listItem = $list->first(function ($item) use ($id) {
      return $item->id === $id;
    });
    return $listItem->id;
  }

  /**
   * @return \Illuminate\Database\Eloquent\Collection
   */
  private function getCacheAllList () {
    return Cache::tags(self::class)->rememberForever($this->getTable(), function () {
      return self::all();
    });
  }
}
