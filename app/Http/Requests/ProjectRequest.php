<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'ID_rfp' => 'required|string|max:100',
            'ID_chercheur' => 'required|string|max:100',
            'nom' => 'required|string|max:100',
            'fichierDoffre' => 'required|string|max:100',
            'plateForme' => 'required|string|max:100',
            'reponse' => 'required|string|max:100',
            'lettreReponse' => 'required|string|max:100',
            'nmbrParticipants' => 'required|string|max:100',
            'lancement'  => 'required|string|max:100',
            'cloture' => 'required|string|max:100',
            'rapportFinal' => 'required|string|max:100'
        ];
    }


    public function messages()
    {
    return [
      'ID_rfp'=>,
      'ID_chercheur'=>,
      'nom'=>,
      'fichierDoffre'=>,
      'plateForme'=>,
      'reponse'=>,
      'lettreReponse'=>,
      'nmbrParticipants'=> ,
      'lancement'=> ,
      'cloture'=>,
      'rapportFinal'=>,
      'password.min' => "le mot de passe doit contenir au moin 8 caracters !",
    ];
    }
}
