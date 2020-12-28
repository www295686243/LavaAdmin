<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\ShareLog
 *
 * @property int $id
 * @property int $share_user_id 分享者
 * @property string $info_classify
 * @property int $info_id
 * @property string $info_title
 * @property int $info_user_id 信息发布者
 * @property int $views 查看数
 * @property int $target_views 目标数
 * @property int $is_complete_task 是否完成任务
 * @property int $max_count 最大张数
 * @property int $give_count 已给张数
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereGiveCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereInfoClassify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereInfoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereInfoUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereIsCompleteTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereMaxCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereShareUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereTargetViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareLog whereViews($value)
 * @mixin \Eloquent
 */
class ShareLog extends Model
{
  protected $connection = 'zhizao';
}
