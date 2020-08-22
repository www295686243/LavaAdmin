<?php

namespace App\Models;

class Chart extends Base
{
  protected $fillable = [
    'stat_date',
    'stat_data'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];
}
