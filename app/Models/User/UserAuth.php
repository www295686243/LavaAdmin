<?php

namespace App\Models\User;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserAuth extends Base
{
  use SoftDeletes, HasSnowflakePrimary;

  protected $fillable = [
    'user_id',
    'wx_openid',
    'wx_unionid'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];
}
