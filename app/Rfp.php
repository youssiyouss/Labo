<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\carbon;

class Rfp extends Model
{
    protected $table = 'rfps';
    protected $fillable = ['maitreOuvrage', 'titre', 'type', 'resumer', 'dateAppel', 'echeance', 'sourceAppel', 'fichier'];
    protected $dates = ['dateAppel' , 'dateEcheance', 'created_at', 'updated_at'];
    protected $times = ['heureAppel' , 'heureEcheance'];


    public function getDateAppelAttribute($value){
      return Carbon::parse($value)->format('Y-m-d');
    }

    public function getDateEcheanceAttribute($value){
      return Carbon::parse($value)->format('Y-m-d');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }

    public function getupdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }
    // public function getHeureAppelAttribute($value){
    //   return Carbon::parse($value)->format('H:m');
    // }
    //
    // public function getHeureEcheanceAttribute($value){
    //  return Carbon::parse($value)->format('H:m');
    // }
}
