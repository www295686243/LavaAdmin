<?php

namespace App\Models\User;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\User\UserWallet
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\UserWallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\UserWallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User\UserWallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @mixin \Eloquent
 */
class UserWallet extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'money',
    'total_earning',
    'point'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];
}