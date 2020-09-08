<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
          'ets' =>'required','string','unique:clients,ets,'.$this->id,
          'email' =>'required' , 'email','unique:clients,email,' . $this->id,
          'tel' =>'nullable','numeric', 'unique:clients,tel,' . $this->id,
          'adresse' =>'nullable', 'string','unique:clients,adresse,' . $this->id,
          'site' =>'required',' url','unique:clients,site,' . $this->id,
        ];
    }

        public function messages()
        {
        return [
            'ets.required' => "Veuillez indiquer le nom du maitre d'ouvrage !",
            'email.required' => "Veuillez indiquer l'email de cete MO' !",
            'adresse.required' => "Veuillez indiquer l'adresse de cet MO !",
            'site.required' => "Veuillez indiquer le site web de cet MO !",
            'ets.unique' => "Le nom de ce client existe deja!",
            'email.unique' => "cet adresse mail existe deja!",
            'tel.unique' => "Ce numero exist deja!",
            'site.unique' => "Ce site web exist deja!",
            'tel.numeric' => "Numero telephone non valide! il doit contenir que des numeros",

        ];
        }
}
