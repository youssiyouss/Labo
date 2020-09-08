<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

              'email' =>'required|string|email|max:150|unique:users,email,'.$this->user()->id,
              'password' => 'required|string|min:8|confirmed',
              'name' => 'required|string|max:100',
              'prenom'=>'required|string|max:100',
              'tel' => 'required|digits_between:9,10',
              'grade' => 'required|String',
              'about' => 'String|max:600',
              'photo'=>'mimes:jpeg,bmp,png,jpg|image|filled',
        ];
    }


          public function messages()
          {
          return [
            'name.required' => "Veuillez indiquer le nom !",
            'name.string' => "le nom doit contenir que des lettres !",
            'name.max' => "le nom ne doit pas depassé 255 caracters !",
            'prenom.required' => "Veuillez indiquer le prenom!",
            'prenom.string' => "le prenom doit contenir que des lettres !",
            'prenom.max' => "le prenom ne doit pas depassé 255 caracters !",
            'tel.required' => "Veuillez indiquer le numéro de téléphne !",
            'tel.digits_between' => "Numéro téléphone trop long/court",
            'grade.required' => "Veuillez indiquer le grade !",
            'photo.mimes' => "format photo non prise en charge !",
            'email.required' => "l'adresse mail est obligatoire !",
            'email.email' => "format mail non valide !",
            'email.unique' => "l'adresse mail doit etre unique, pour ne pas avoir une confusion au moment d'authentification !",
            'password.required' => "Veuillez remplir se champ !",
            'password.confirmed' => "Le mot de passe n'est pas identique avec la confirmation !",
            'password.min' => "le mot de passe doit contenir au moin 8 caracters !",
          ];
          }
}
