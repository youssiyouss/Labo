<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\carbon;

class Projet extends Model
{

  protected $table = 'projets';
  protected $fillable = ['ID_rfp','chefDeGroupe', 'nom', 'fichierDoffre', 'plateForme', 'reponse', 'lettreReponse', 'nmbrParticipants' ,'lancement' , 'cloture','rapportFinal'];
  protected $dates = ['lancement' , 'cloture','created_at','updated_at'];
  protected $files = ['fichierDoffre' , 'lettreReponse','rapportFinal'];

  public function getLancementAttribute($value){
    return Carbon::parse($value)->format('d/m/Y');
  }

  public function getClotureAttribute($value){
    return Carbon::parse($value)->format('d/m/Y');
  }
}
