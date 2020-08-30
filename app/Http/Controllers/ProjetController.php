<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ProjetRequest;
use App\Projet;
use Auth;
use App\User;
use Carbon\carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ProjetController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function index(){
        $liste = DB::table('projets')
            ->join('users', 'users.id', '=', 'projets.ID_chercheur')
            ->select('projets.*', 'users.name', 'users.prenom', 'users.photo')
            ->get();
	      return view('soumissions.index', ['soumission' =>$liste]);
     }

     public function create(){
          $rfps = DB::table('rfps')
              ->select('rfps.id','rfps.titre','rfps.type')
              ->orderby('rfps.type')
              ->get();
              return view('soumissions.create', ['rfps' => $rfps]);

     }

     public function store(Request $request){
       $temp = DB::table('users')
           ->select('users.id')
           ->where('users.grade','=','Directeur')
           ->get();
     $soumission = new Projet();
     $soumission->nom = $request->input('nom');
     $soumission->ID_rfp = $request->input('ID_rfp');
     $soumission->ID_chercheur =Auth::user()->id;
     $soumission->plateForme = $request->input('plateForme');
     $soumission->reponse = $request->input('reponse');
      if($request->input('lancement')){
        $soumission->lancement =  Carbon::createFromFormat('m/d/Y', $request->lancement)->format('Y-m-d');
      }
     $soumission->nmbrParticipants = $request->input('nmbrParticipants');
       if($request->input('cloture')){
         $soumission->cloture = Carbon::createFromFormat('m/d/Y', $request->cloture)->format('Y-m-d');
      }
     if($request->hasFile('lettreReponse')){
       $fn= $request->lettreReponse->getClientOriginalName();
       $soumission->lettreReponse = $request->lettreReponse->storeAs('file',$fn);
     }
     if($request->hasFile('rapportFinal')){
       $fn= $request->rapportFinal->getClientOriginalName();
       $soumission->rapportFinal = $request->rapportFinal->storeAs('file',$fn);
     }
     if($request->hasFile('fichierDoffre')){
       $fn= $request->fichierDoffre->getClientOriginalName();
       $soumission->fichierDoffre = $request->fichierDoffre->storeAs('file',$fn);
     }

     if ($soumission->save()) {

     Session()->flash('success', "le projet : ".$soumission->nom." a été ajouté avec succées!!");

    } else {
       session()->flash('error', 'Enregistrement échouée!!');
   }
     return redirect('projets');

 }
  public function edit($id){
     	$soumission = Projet::find($id);
      $first = DB::table('rfps')->select('rfps.id','rfps.titre','rfps.type')->get();
     		return view('soumissions.edit', ['soumission' => $soumission,'rfps'=>$first ]);
     }

 public function update(Request $request, $id){
  	$soumission = Projet::find($id);
 		 $soumission->nom = $request->input('nom');
     $soumission->ID_rfp = $request->input('ID_rfp');
     $soumission->plateForme = $request->input('plateForme');
     $soumission->nmbrParticipants = $request->input('nmbrParticipants');
     $soumission->reponse = $request->input('reponse');
     $soumission->lancement = Carbon::createFromFormat('m/d/Y', $request->lancement)->format('Y-m-d');
     $soumission->cloture = Carbon::createFromFormat('m/d/Y', $request->cloture)->format('Y-m-d');
      if($request->hasFile('lettreReponse')){
         $fn= $request->lettreReponse->getClientOriginalName();
         $soumission->lettreReponse = $request->lettreReponse->storeAs('file',$fn);
       }
     if($request->hasFile('rapportFinal')){
       $fn= $request->rapportFinal->getClientOriginalName();
       $soumission->rapportFinal = $request->rapportFinal->storeAs('file',$fn);
     }
     if($request->hasFile('fichierDoffre')){
       $fn= $request->fichierDoffre->getClientOriginalName();
        $soumission->fichierDoffre = $request->fichierDoffre->storeAs('file',$fn);
     }
     if ($soumission->save()) {

     Session()->flash('success', "le projet : ".$soumission->nom." a été modifié avec succées!!");

      } else {
         session()->flash('error', 'Modification échouée!!');
     }
 	return redirect('projets');
     }

 public function destroy (Request $request, $id){
     	$soumission = Projet::find($id);
     	$soumission->delete();
         session()->flash('success', 'le projet : '.$soumission->nom.' est supprimer de la liste avec succées');
     	return redirect('projets');

 }

 public function fileDownloader($id){
   $file= Projet::find($id);
   $infoPath = pathinfo($file->fichierDoffre);
   $extension = $infoPath['extension'];
   $name = Str::afterLast($file->fichierDoffre, 'file/');

   return response()->download(storage_path("app/public/{$file->fichierDoffre}"),$name );        // Storage::download($file->fichier,$file->titre);
   session()->flash('success', "Téléchargement de l'offre..")->redirect('projets');

 }

}
