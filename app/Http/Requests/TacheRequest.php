<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TacheRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $dateD=FormRequest::get('dateDebut');
        return [
                'titreTache' =>'required',
                'description' =>'required','text','max:800','nullable',
                'priorite' =>'string',
                'dateDebut' => 'date','nullable',
                'dateFin' =>'required','date','after : '.$dateD,
                'fichierDetail' =>'file',
                'ID_chercheur' =>'required' ,
                'ID_projet' =>'required',

        ];
    }


    public function messages()
    {
        return [
            'titreTache.required' => "Veuillez indiquer c'est quoi cette tache !",
            'description.required' => "Veuillez expliquer brièvement cette tache  !",
            'dateFin.required' => "Veuillez indiquer le dernier delai pour delivrer cette tache !",
            'ID_chercheur.required' => "Veuillez indiquer a qui vous voulez affecter cette tache !",
            'ID_projet.required' => "Le projet de cette tache est ambigue!",
            'dateDebut.date' => "Format date non valide",
            'dateFin.date' => "Format date non valide",
            'dateFin.after' => "Date non valide ! elle doit etre superieur a la date de debut de tache",
            'description.max' => "Description de tache trop long! veuillez télécharger un fichier descriptif pour plus detaillé cette tache",
            'fichierDetail.file' => "Ceci n'est pas un fichier"
        ];
    }
}
