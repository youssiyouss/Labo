<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livrable extends Model
{
    protected $table = 'delivrables';
    protected $fillable = ['contenu', 'avancement', 'commentaire', 'id_respo', 'id_tache'];
    protected $dates = ['created_at', 'updated_at'];

}
