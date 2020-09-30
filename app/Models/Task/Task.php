<?php

namespace App\Models\Task;

use App\Models\Base;

class Task extends Base
{
  protected $fillable = [
    'title',
    'desc'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];
}
