<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SugarUsersBlocked extends Model
{
    use HasFactory;
    protected $table = 'sugar_users_blocked';
    protected $fillable = ['sugar_user_id',
      'date_unblocked',
      'user_creation',
      'user_modified',
      'sources_blocked',
      'medios_blocked',
      'sugar_user_agency',
      'status'
      ];
}
