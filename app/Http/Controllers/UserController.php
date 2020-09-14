<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use  Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
   public function __construct()
   {
       $this->middleware('auth');
   }


      public function index() {

        $this->authorize('viewAny', User::class);
          $x = User::all()->unique('email');
          return view('chercheurs.index',['chrchr'=>$x]);
        }


      public function create() {
          $this->authorize('create', User::class);
          return view('chercheurs.create');
      }

      public function store(UserRequest $request) {

        $x = new User();
        $x->name= $request->input('name');
        $x->prenom = $request->input('prenom');
        $x->tel = $request->input('tel');
        $x->grade = $request->input('grade');
        $x->about = $request->input('about');
        $x->email = $request->input('email');
        $x->password = Hash::make($request->input('password'));
        if($request->hasFile('photo')){
          $user= $request->input('nom').'_'. $request->input('prenom').'.'.$request->photo->getClientOriginalExtenSion();
           $x->photo = $request->photo->storeAs('avatars',$user);
        }
        $x->save();

        session()->flash('success',"{$x->name} {$x->prenom} a été ajoutés avec succés!");
        return redirect('chercheurs');
      }

      public function edit($id) {
        $x = User::find($id);
        $this->authorize('update',$x);
        return view('chercheurs.edit',['chrch'=>$x]);
      }

      public function update(UserRequest $request,$id) {
        $x = User::find($id);
        $x->name= $request->input('name');
        $x->prenom = $request->input('prenom');
        $x->tel = $request->input('tel');
        $x->grade = $request->input('grade');
        $x->about = $request->input('about');
        $x->email = $request->input('email');
        $x->password = Hash::make($request->input('password'));
        if($request->hasFile('photo')){
           $user= $request->input('nom').'_'. $request->input('prenom').'.'.$request->photo->getClientOriginalExtenSion();
           $x->photo = $request->photo->storeAs('avatars',$user);
          }
       $x->save();
      session()->flash('success',"{$x->name} {$x->prenom} a été modifié avec succés!");
      return redirect('/home');
      }

      public function destroy(Request $request , $id) {
        $x = User::find($id);
        $this->authorize('delete',$x);
        $x->delete();
        session()->flash('success',"{$x->name} {$x->prenom} a été supprimer avec succés");
        return redirect('chercheurs');
      }

      public function show($id) {
        $x = User::find($id);
        $this->authorize('view',$x);
        return view('chercheurs.show',['chrch'=>$x]);
      }

}
