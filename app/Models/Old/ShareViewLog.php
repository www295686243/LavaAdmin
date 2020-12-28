<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\ShareViewLog
 *
 * @property int $id
 * @property int $user_id 访问者
 * @property int $share_user_id 分享者
 * @property string $info_classify
 * @property int $info_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog whereInfoClassify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog whereInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog whereShareUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShareViewLog whereUserId($value)
 * @mixin \Eloquent
 */
class ShareViewLog extends Model
{
  protected $connection = 'zhizao';
}
