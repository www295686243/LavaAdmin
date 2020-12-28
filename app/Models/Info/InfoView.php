<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Info\InfoView
 *
 * @property int|null|string $id
 * @property string $info_viewable_type
 * @property string $info_viewable_id
 * @property string|null $share_user_id 分享者
 * @property string $user_id 访问者
 * @property int $is_new_user 是否新用户
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $info_viewable
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView whereInfoViewableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView whereInfoViewableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView whereIsNewUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView whereShareUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InfoView whereUserId($value)
 * @mixin \Eloquent
 */
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
