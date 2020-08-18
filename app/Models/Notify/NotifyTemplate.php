<?php

namespace App\Models\Notify;

use App\Models\Base;

class NotifyTemplate extends Base
{
  protected $fillable = [
    'title',
    'template_id',
    'content',
    'remark',
    'url',
    'keyword_names'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'keyword_names' => 'array',
  ];
}
