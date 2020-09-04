<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RfpRequest extends FormRequest
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
      $dateDebut = FormRequest::get('dateAppel');
        return [
          'maitreOuvrage' =>'required | distinct',
          'titre' =>'required','string','max:150', \Illuminate\Validation\Rule::unique('rfps')->ignore($this->id),
          'type' =>'required',
          'resumer' =>'required', 'max:1000',
          'dateAppel' =>'required | date',
          'dateEcheance' =>'required | date |after : '.$dateDebut,
          'heureEcheance' =>'required',
          'sourceAppel' =>'required',
          'fichier' =>'file',\Illuminate\Validation\Rule::unique('rfps')->ignore($this->id),

        ];
    }

    public function messages()
    {
    return [
        'maitreOuvrage.required' => "Veuillez indiquer le maitre d'ouvrage !",
        'titre.required' => "Veuillez indiquer le type de cet RFP !",
        'type.required' => "Veuillez indiquer la nature de cet RFP !",
        'resumer.required' => "Veuillez expliquer brièvement en quoi consiste cet RFP !",
        'dateAppel.required' => "Veuillez indiquer la date d'apparition de cet RFP!",
        'dateEcheance.required' => "Veuillez indiquer la date d'échéance pour cet RFP !",
        'heureEcheance.required' => "Veuillez indiquer l'heure d'échéance pour cet RFP !",
        'sourceAppel.required_if' => "Veuillez indiquer soit la source cet RFP et/ou aumoin  le fichier de cet RFP !",
        'fichier.required_if' => "Veuillez indiquer soit la source cet RFP et/ou aumoin  le fichier de cet RFP !",
        'resumer.max' => "Le resumer est trop long! essayer de ne pas dépasser 600 caractères",

        'titre.unique' => "Cet RFP existe deja!",
        'resumer.unique' => "Cet RFP existe deja avec un titre different! ",
        'fichier.unique' => 'Ce fichier exist deja!',
        'fichier.mimes' => "Le fichier ne doit pas etre vide!",
        'sourceAppel.required_if' => "Vous devez indiquez soit la source de cet RFP, soit télécharger le fichier décrivant l'RFP",
        'dateEcheance.after'=> "la date de cet RFP est expiré ! vérifier la date d'écheance",
        'dateAppel.date' => "Date non valide!",
        'dateEcheance.date' => "Date non valide!",
        // 'heureAppel.TimeZone' => "heure non valide!",
        // 'heureEcheance.TimeZone' => "heure non valide!",


    ];
    }
}
