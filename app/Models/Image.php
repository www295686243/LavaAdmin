<?php

namespace App\Models;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

/**
 * \App\Models\Image
 *
 * @property int $id
 * @property int $user_id 上传的会员id
 * @property string $imageable_type
 * @property int $imageable_id
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
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereMarking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereWidth($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
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
