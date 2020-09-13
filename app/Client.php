<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  protected $table = 'clients';
  protected $fillable = ['ets', 'email', 'tel', 'adresse', 'site'];
  protected $dates = ['created_at', 'updated_at'];


}
