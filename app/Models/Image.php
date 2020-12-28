<?php

namespace App\Models;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Image
 *
 * @property int|null|string $id
 * @property string $user_id 上传的会员id
 * @property string $imageable_type
 * @property string $imageable_id
 * @property string $name 文件名称
 * @property string $url 文件路径
 * @property string $mime Mime类型
 * @property int $size 文件大小
 * @property float $width 图片宽度
 * @property float $height 图片高度
 * @property int|null $marking 标记(信息发布时用到)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_url
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static Builder|Image newModelQuery()
 * @method static Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static Builder|Image whereCreatedAt($value)
 * @method static Builder|Image whereHeight($value)
 * @method static Builder|Image whereId($value)
 * @method static Builder|Image whereImageableId($value)
 * @method static Builder|Image whereImageableType($value)
 * @method static Builder|Image whereMarking($value)
 * @method static Builder|Image whereMime($value)
 * @method static Builder|Image whereName($value)
 * @method static Builder|Image whereSize($value)
 * @method static Builder|Image whereUpdatedAt($value)
 * @method static Builder|Image whereUrl($value)
 * @method static Builder|Image whereUserId($value)
 * @method static Builder|Image whereWidth($value)
 * @mixin \Eloquent
 */
class Image extends Base
{
  protected $fillable = [
    'user_id',
    'imageable_type',
    'imageable_id',
    'name',
    'url',
    'mime',
    'size',
    'width',
    'height',
    'marking'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @var array
   */
  protected $appends = [
    'full_url'
  ];

  /**
   * @var array
   */
  protected $casts = [
    'imageable_id' => 'string'
  ];

  /**
   * @return string
   */
  public function getFullUrlAttribute()
  {
    return Storage::url($this->url);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function imageable()
  {
    return $this->morphTo();
  }

  /**
   * @param $info_id
   */
  public function updateImageableId($info_id)
  {
    $marking = request()->input('marking');
    self::where('marking', $marking)->update(['imageable_id' => $info_id]);
    $this->destroySurplus();
  }

  /**
   * 删除多余图片
   * @return mixed
   */
  private function destroySurplus()
  {
    $query = self::where('imageable_id', 0)->orWhereNull('imageable_id');
    return $this->delImages($query);
  }

  /**
   * @param Builder $query
   * @return mixed
   */
  public function delImages(Builder $query)
  {
    $list = $query->get();
    foreach ($list as $item) {
      Storage::delete($item->url);
    }
    return $query->delete();
  }
}
