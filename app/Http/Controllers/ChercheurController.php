<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

class ChercheurController extends Controller
{
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

      public function index() {
        $x = User::all();
      return view('chercheurs.index',['chrchr'=>$x]);
      }

      public function create() {
          return view('chercheurs.create');
      }

      public function store(Request $request) {
        $x = new User();
        $x->name= $request->input('nom');
        $x->prenom = $request->input('prenom');
        $x->tel = $request->input('tel');
        $x->grade = $request->input('grade');
        $x->about = $request->input('about');
        if($request->hasFile('photo')){
          $user= $request->input('nom').'_'. $request->input('prenom').'.'.$request->photo->getClientOriginalExtenSion();
           $x->photo = $request->photo->storeAs('avatars',$user);
        }
        $x->email = $request->input('email');
        $x->password = Hash::make($request->input('password'));

          $x->save();
        session()->flash('success',"{$x->name} {$x->prenom} a été ajoutés avec succés!");
        return redirect('chercheurs');
      }

      public function edit($id) {
        $x = User::find($id);
        return view('chercheurs.edit',['chrch'=>$x]);
      }

      public function update(Request $request,$id) {
        $x = User::find($id);
        if($request->has('name')){$x->name= $request->input('nom');}
        if($request->hasFile('prenom')){$x->prenom = $request->input('prenom');}
        if($request->hasFile('tel')){$x->tel = $request->input('tel');}
        if($request->hasFile('grade')){$x->grade = $request->input('grade');}
        if($request->hasFile('about')){$x->about = $request->input('about');}
        if($request->hasFile('photo')){
           $user= $request->input('nom').'_'. $request->input('prenom').'.'.$request->photo->getClientOriginalExtenSion();
           $x->photo = $request->photo->storeAs('avatars',$user);
          }
        if($request->hasFile('email')){$x->email = $request->input('email');}
        if($request->hasFile('password')){$x->password = Hash::make($request->input('password'));}


       $x->save();
      session()->flash('success',"{$x->name} {$x->prenom} a été modifié avec succés!");
      return redirect('chercheurs');
      }

      public function destroy(Request $request , $id) {
        $x = User::find($id);
        $x->delete();
        session()->flash('success',"{$x->name} {$x->prenom} a été supprimer avec succés");
        return redirect('chercheurs');
      }
}
