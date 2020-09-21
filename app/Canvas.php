<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canvas extends Model
{
    protected $table = 'canvases';
    protected $fillable = ['pour', 'canvas'];
    protected $dates = ['created_at', 'updated_at'];

}
