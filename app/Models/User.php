<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * \App\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
  use Notifiable, HasSnowflakePrimary;

  protected $fillable = [
    'username',
    'nickname',
    'email',
    'phone',
    'password'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];
}
