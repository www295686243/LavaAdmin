<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfoSub extends Base
{
  use SoftDeletes;
  protected $fillable = [
    'description'
  ];

  protected $hidden = [
    'id',
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function info_subable()
  {
    return $this->morphTo();
  }
}
