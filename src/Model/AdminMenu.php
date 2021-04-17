<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AdminMenu extends Model
{
  protected $table = 'admin_menu';

  protected $fillable = [
    'name',
    'title',
    'url',
  ];
}
