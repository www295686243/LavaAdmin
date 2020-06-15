<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class News extends Base
{
  use HasSnowflakePrimary, SoftDeletes;
  protected $fillable = [
    'user_id',
    'text',
    'textarea',
    'select',
    'radio',
    'switch',
    'datetime',
    'checkbox',
    'counter',
    'file',
    'image',
    'files',
    'images',
    'cascader',
    'editor'
  ];

  protected $casts = [
    'checkbox' => 'array',
    'files' => 'array',
    'images' => 'array',
  ];
}
