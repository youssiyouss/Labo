<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;
    protected $table = 'emails';
    protected $fillable = ['to', 'subject','from','tag', 'message'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at','read_at'];
}
