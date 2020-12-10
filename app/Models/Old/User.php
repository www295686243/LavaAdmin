<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'industries' => 'array',
  ];

  public function user_info()
  {
    return $this->hasOne(UserInfo::class, 'id', 'id');
  }

  public function user_auth()
  {
    return $this->hasOne(Auth::class);
  }
}
