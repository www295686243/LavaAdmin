<?php

namespace App\Models;

use App\Models\Traits\ResourceTrait;

class Role extends \Spatie\Permission\Models\Role
{
  use ResourceTrait;

  protected $casts = [
    'menu_permissions' => 'array'
  ];
}
