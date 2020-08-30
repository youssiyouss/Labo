<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjetRequest extends FormRequest
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
         return [
             'ID_rfp' => 'required',
             'ID_chercheur' => 'required',
             'nom' => 'required','string','max:255','unique:projets',
             'plateForme' => 'required',
             'fichierDoffre' => 'required|file',
             'reponse' => 'present|string',
             'lettreReponse' => 'present|file',
             'nmbrParticipants' => 'present|numeric',
             'lancement'  => 'present|date',
             'cloture' => 'present|date',
             'rapportFinal' => 'present|file',
         ];
     }


     public function messages()
     {
       return [
         'ID_rfp.required'=>"Veuillez indiquer pour quel Rfp vous soumettez!",
         'nom.required'=>"Veuillez indiquer le titrede votre soumission!",
         'nom.max'=>"le titre est trop long!",
         'nom.unique'=>"Ce titre existe déja!",
         'plateForme.require' => "Veuillez indiquer où vous avez soumis votre offre!",
         'fichierDoffre.required'=>"Veuillez télécharger el fichier de votre présentation",
         'fichierDoffre.file'=>"Ceci n'est pas un fichier",
         'reponse.string'=>"Veuillez indiquer si vous etes : (Accepté/Refusé/Accepté avec reserve)",
         'lettreReponse.file'=>"Ceci n'est pas un fichier!",
         'nmbrParticipants.numeric'=>"Veuillez saisir le nombre d'elements dans votre groupe!",
         'lancement.date'=>"Veuillez saisir la date de lancement de votre projet!" ,
         'cloture.date'=>"Veuillez saisir la date prevu pour la fin de votre projet!",
         'rapportFinal.file'=>"Ceci n'est pas un fichier!",

       ];
     }
}
