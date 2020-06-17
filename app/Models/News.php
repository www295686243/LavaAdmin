<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * \App\Models\News
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $text
 * @property string|null $textarea
 * @property int|null $select
 * @property int|null $radio
 * @property int|null $switch
 * @property string|null $datetime
 * @property array|null $checkbox
 * @property int|null $counter
 * @property string|null $file
 * @property string|null $image
 * @property array|null $files
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property int|null $cascader
 * @property string|null $editor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereCascader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereCheckbox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereEditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereRadio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereSwitch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereTextarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News withoutTrashed()
 * @mixin \Eloquent
 */
class News extends Base
{
  use HasSnowflakePrimary, SoftDeletes;

  protected $fillable = [
    'user_id',
    'text',
    'textarea',
    'select',
    'radio',
    'switch',
    'datetime',
    'checkbox',
    'counter',
    'file',
    'image',
    'files',
    'images',
    'cascader',
    'editor'
  ];

  protected $casts = [
    'checkbox' => 'array',
    'files' => 'array',
    'images' => 'array',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function images()
  {
    return $this->morphMany('App\Models\Image', 'imageable');
  }
}
