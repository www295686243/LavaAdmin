<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\User\User;
use Kra8\Snowflake\HasSnowflakePrimary;

class Hr extends Base
{
  use HasSnowflakePrimary;
  protected $fillable = [
    'user_id',
    'title'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
