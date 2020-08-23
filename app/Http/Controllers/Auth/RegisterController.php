<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'prenom'=> ['required', 'string' , 'max:255'],
            'tel' => ['required','digits_between:9,10','distinct'],
            'grade' => ['required','String'],
            'about' => ['String'],
            'photo'=> ['mimes:jpeg,bmp,png,jpg','image','filled'],

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $x = new User();
        $x->name= $request->input('name');
        $x->prenom = $request->input('prenom');
        $x->tel = $request->input('tel');
        $x->grade = $request->input('grade');
        $x->about = $request->input('about');
        if($request->hasFile('photo')){
          $x->photo = $request->photo->store('images');
        }
        $x->email = $request->input('email');
        $x->password = Hash::make($request->input('password'));

          $x->save();
        session()->flash('success',"{$x->name} {$x->prenom} a été ajoutés avec succés!");
        return redirect('/');
    }
}
