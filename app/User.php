<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;
use App\Notifications\InvoicePaid;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'users';
     protected $fillable = ['name', 'prenom', 'email', 'password', 'tel', 'grade', 'about', 'photo',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime',];
    /**
     * The attributes that are dates
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'  ];
    protected $files = ['photo',];

}
