<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSub extends Model
{
  protected $connection = 'zhizao';

  protected $casts = [
    'treatment' => 'array',
  ];
}
