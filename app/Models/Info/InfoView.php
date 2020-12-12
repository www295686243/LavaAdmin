<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class InfoView extends Base
{
  protected $fillable = [
    'info_viewable_type',
    'info_viewable_id',
    'share_user_id',
    'user_id',
    'is_new_user'
  ];

  protected $casts = [
    'info_viewable_id' => 'string',
    'share_user_id' => 'string',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function info_viewable()
  {
    return $this->morphTo();
  }

  /**
   * @param $request
   * @param HrResume|HrJob $infoData
   * @throws \Throwable
   */
  public function createView($request, $infoData)
  {
    $user_id = User::getUserId();
    $share_user_id = $request->input('su');
    if ($share_user_id) {
      $isExists = $infoData->info_view()
        ->where('user_id', $user_id)
        ->where('share_user_id', $share_user_id)
        ->exists();
    } else {
      $isExists = $infoData->info_view()->where('user_id', $user_id)->exists();
    }
    $isNewMember = InfoView::where('user_id', $user_id)->exists();
    if ($infoData->user_id !== $user_id) {
      DB::beginTransaction();
      try {
        if (!$isExists) {
          $infoData->info_view()->create([
            'share_user_id' => $share_user_id,
            'user_id' => $user_id,
            'is_new_user' => !$isNewMember
          ]);
        }
        $infoData->views += 1;
        $infoData->save();
        $infoData->checkShareFinishTask();
        DB::commit();
      } catch (\Exception $e) {
        DB::rollBack();
        \Log::error($e->getMessage());
        $this->error('访问失败');
      }
    }
  }
}
