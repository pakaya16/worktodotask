<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Todo extends Model
{
  use SoftDeletes;

  protected $table      = 'todo';
  protected $dates      = ['deleted_at'];
  protected $softDelete = true;
  protected $fillable   = ['id',
                           'subject',
                           'detail',
                           'status'];
}
