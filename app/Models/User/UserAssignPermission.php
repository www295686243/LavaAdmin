<?php

namespace App\Models\User;

use App\Models\Base\Base;

class UserAssignPermission extends Base
{
  protected $fillable = [
    'role_id',
    'permission_id',
    'platform'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];
}
