<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Tache;
use App\Projet;
use App\Delivrable;
use App\Http\Requests\TacheRequest;
use Illuminate\Support\Facades\DB;
use auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function index()
    {
      $list = DB::table('taches')
            ->join('projets', 'projets.id', '=', 'taches.ID_projet')
            ->join('users', 'users.projetGere', '=', 'projets.id')
            ->select('taches.*', 'projets.nom','users.photo','users.name', 'users.prenom')
            ->where('users.id','=',Auth::user()->id)
            ->get();
         return view('taches.index' , ['taches' => $list]);

    }*/
    public function tousLesTaches($id){
        $id = Projet::find($id)->id;
        $name = Projet::find($id)->nom;

        $liste = DB::table('taches')
        ->join('projets', 'projets.id', '=', 'taches.ID_projet')
        ->join('users', 'projets.id', '=', 'users.projetGere')
        ->select('taches.*', 'projets.nom','users.photo','users.name', 'users.prenom')
        ->where([ ['projets.id','=', $id] , ['users.id',"=",Auth::user()->id]] )
        ->get();
      return view('taches.tousLesTaches', ['taches' =>$liste, 'Projectid' =>$id,'Projectname' =>$name ]);
    }

    public function mesTaches($id){
        $id = Projet::find($id)->id;
        $name = Projet::find($id)->nom;

        $liste = DB::table('delivrables')
        ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
        ->join('users', 'users.id', '=', 'delivrables.id_respo')
        ->join('projets', 'projets.id', '=', 'taches.ID_projet')
        ->select('taches.*', 'projets.nom')
        ->where([
            ['projets.id', '=', $id],
            ['users.id', '=', Auth::user()->id],
        ])->get();

      return view('taches.mesTaches',  ['taches' => $liste,'Projectid' =>$id,'Projectname' =>$name]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
      $projet = Projet::find($id)->id;
      $chercheurs= DB::table('users')
          ->select('users.id','users.name','users.prenom')
          ->orderby('users.name',"asc")
          ->get();
          return view('taches.create', ['ch' => $chercheurs , 'ID_projet' => $projet]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$projet)
    {

      $tache = new Tache();
      $tache->ID_projet =$projet;
      $tache->titreTache  = $request->input('titreTache');
      $tache->description = $request->input('description');
      $tache->priorite = $request->input('priorite');
      if($request->input('dateDebut') == NULL){
          $tache->dateDebut = Carbon::now();}
      else{
          $tache->dateDebut = $request->input('dateDebut');}
      $tache->dateFin = $request->input('dateFin');
      if($request->hasFile('fichierDetail')){
         $fn= $request->fichierDetail->getClientOriginalName();
      	 $tache->fichierDetail = $request->fichierDetail->storeAs('file',$fn);
      }

      if ($tache->save()) {
        $respos =  $request->input('ID_chercheur', array());
        foreach ($respos as $key => $ch) {
            $deli = new Delivrable();
            $deli->id_respo  =$ch;
            $deli->id_tache =$tache->id;
            $deli->save();
          }
        Session()->flash('success', "la tache : ".$tache->titreTache." a été crée avec succées!!");
    } else {
        Session()->flash('error', 'Enregistrement echouée!!');
    }
    return redirect('taches/tousLesTaches/'.$tache->ID_projet);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function edit($tache)
    {
        $t = Tache::find($tache);
     	$chercheurs= DB::table('users')
            ->select('users.id','users.name','users.prenom')
            ->orderby('users.name',"asc")
            ->get();

        return view('taches.edit', ['ch' => $chercheurs , 't' => $t]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tache  $tache
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id) {
        $tache = Tache::find($id);
        $tache->titreTache  = $request->input('titreTache');
       //$tache->ID_projet =Session::get('ID_projet');;
        $tache->description = $request->input('description');
        $tache->dateDebut = $request->input('dateDebut');
        $tache->dateFin = $request->input('dateFin');
        $tache->priorite = $request->input('priorite');

        if($request->hasFile('fichierDetail')){
         $fn= $request->fichierDetail->getClientOriginalName();
      	 $tache->fichierDetail = $request->fichierDetail->storeAs('file',$fn);
      }

        if ($tache->save()) {
        Session()->flash('success', "la tache : '".$tache->titreTache."' a été modifiée avec succées!!");
        } else {
        Session()->flash('error', 'Modification echouée!!');
        }
        return redirect('taches/tousLesTaches/'.$tache->ID_projet);
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tache  $tache
     * @return \Illuminate\Http\Response
     */
    public function destroy($tache)
    {
      $tache = Tache::find($tache);
      $tache->delete();
      session()->flash('success', 'la tache'.$tache->titreTache. 'a été supprimer définitivement');
      return redirect('taches/tousLesTaches/'.$tache->ID_projet);
    }


    public function fileDownloader($id){

      $file= Tache::find($id);
       $infoPath = pathinfo($file->fichierDetail);
       $extension = $infoPath['extension'];
       $name = Str::afterLast($file->fichierDetail, 'file/');
       print_r($extension);

       if (Storage::disk('local')->exists($file->fichierDetail)){
          return response()->download(storage_path("app/public/{$file->fichierDetail}"),$name );
          Session()->flash('success', "le fichier a été télécharger dans votre ordinateur avec succées!!")->redirect('taches');
      } else {
        Session()->flash('error', "Un erreur c'est produit !!veuillez réessayer");
        return redirect('taches');
      }

     }
}
