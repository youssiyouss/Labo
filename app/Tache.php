<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\carbon;

class Tache extends Model
{

  protected $table = 'taches';
  protected $fillable = [ 'ID_projet','titreTache', 'description', 'priorite', 'dateDebut', 'dateFin', 'fichierDetail'];
  protected $dates = ['dateDebut' , 'dateFin' ,'created_at' , 'updatred_at'];

  public function getDateDebutAttribute($value){
    return Carbon::parse($value)->format('Y-m-d');
  }

  public function getDateFinAttribute($value){
    return Carbon::parse($value)->format('Y-m-d');
  }

}
