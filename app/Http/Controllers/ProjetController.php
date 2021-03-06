<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ProjetRequest;
use App\Projet;
use App\User;
use Auth;
use App\Notifications\InvoicePaid;
use Notification;
use Carbon\carbon;
use Illuminate\Support\Facades\Storage;

class ProjetController extends Controller
{

    public function __construct()
  {
      $this->middleware('auth');
  }



     public function index(){
         $liste = DB::table('projets')
            ->join('users', 'users.id', '=', 'projets.chefDeGroupe')
            ->select('projets.*', 'users.name', 'users.prenom', 'users.photo')
            ->orderBy('projets.chefDeGroupe')
            ->get();
	      return view('soumissions.index', ['soumission' =>$liste]);
     }

    public function show($id)
    {
        $projet= DB::table('projets')
        ->join('users', 'users.id', '=', 'projets.chefDeGroupe')
        ->join('rfps', 'rfps.id', '=', 'projets.ID_rfp')
        ->leftjoin('clients', 'clients.id', '=', 'rfps.maitreOuvrage')
        ->select('projets.*', 'users.name', 'users.prenom','rfps.titre','clients.ets')
        ->where('projets.id','=',$id)
        ->orderBy('projets.chefDeGroupe')
        ->first();
        return view('soumissions.show', ['projet' => $projet]);
    }

     public function create(){
          $rfps = DB::table('rfps')
              ->select('rfps.id','rfps.titre','rfps.type')
              ->orderby('rfps.type')
              ->get();
              return view('soumissions.create', ['rfps' => $rfps]);

     }

     public function store(Request $request){

     $soumission = new Projet();
     $soumission->nom = $request->input('nom');
     $soumission->ID_rfp = $request->input('ID_rfp');
     $soumission->chefDeGroupe = Auth::user()->id;
     $soumission->descriptionProjet = $request->input('descriptionProjet');
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
            $user = auth()->User()->all();
            $alerte = collect([
                'type' => 'Nouveau Projet',
                'title' => Auth::user()->name . " " . Auth::user()->prenom." a soumis un nouveau projet pour l'RFP : '". $soumission->ID_rfp."' ! allez voir",
                'id' => $soumission->ID_rfp,
                'par' => Auth::user()->name . "  " . Auth::user()->prenom,
                'voir' => 'projets/' . $soumission->id
            ]);
            Notification::send($user, new InvoicePaid($alerte));
       Session()->flash('success', "le projet : ".$soumission->nom." a été ajouté avec succées!!");

    } else {
       session()->flash('error', 'Enregistrement échouée!!');
   }
     return redirect('projets');

 }
  public function edit($id){

        $soumission = Projet::find($id);
        $this->authorize('update', $soumission);
        $first = DB::table('rfps')->select('rfps.id','rfps.titre','rfps.type')->get();
     		return view('soumissions.edit', ['soumission' => $soumission,'rfps'=>$first ]);
     }

 public function update(Request $request, $id){
  	$soumission = Projet::find($id);
 	$soumission->nom = $request->input('nom');
     $soumission->ID_rfp = $request->input('ID_rfp');
     $soumission->descriptionProjet = $request->input('descriptionProjet');
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
            $user = auth()->User()->all();
            $alerte = collect([
                'type' => 'Modifier Projet',
                'title' => "Le projet : '" . $soumission->nom . "' a été modifier ! allez voir il y a quoi de nouveau",
                'id' => $soumission->id,
                'par' => Auth::user()->name . "  " . Auth::user()->prenom,
                'voir' => 'projets/' . $soumission->id
            ]);
            Notification::send($user, new InvoicePaid($alerte));
     Session()->flash('success', "le projet : ".$soumission->nom." a été modifié avec succées!!");

      } else {
         session()->flash('error', 'Modification échouée!!');
     }
 	return redirect('projets');
     }

 public function destroy ($id){
     	$soumission = Projet::find($id);
        $soumission->delete();
        $user = auth()->User()->all();
        $alerte = collect([
            'type' => 'Supprimer Projet',
            'title' => "Le projet : '".$soumission->nom."' a été supprimer de la liste des soumissions",
            'id' => $soumission->id,
            'par' => Auth::user()->name . "  " . Auth::user()->prenom,
            'voir' => ''
        ]);
        Notification::send($user, new InvoicePaid($alerte));
         session()->flash('success', 'le projet : '.$soumission->nom.' est supprimer de la liste avec succées');
     	return redirect('projets');

 }

 public function fileDownloader($id){
   $file= Projet::find($id);
   $infoPath = pathinfo($file->fichierDoffre);
   $extension = $infoPath['extension'];
   $name = Str::afterLast($file->fichierDoffre, 'file/');
   if (Storage::disk('local')->exists($file->fichierDoffre)){
       $user = Auth::user();
       $alerte = collect([
           'type' => 'Download',
           'title' => "Le fichier : '" . $name . "' du projet " . $file->nom . " a été télécharger avec succés",
           'par' => Auth::user()->name . "  " . Auth::user()->prenom,
           'voir' => ''
           ]);
           Notification::send($user, new InvoicePaid($alerte));
           session()->flash('success', "Téléchargement de l'offre..");
           return redirect('projets');
           return response()->download(storage_path("app/public/{$file->fichierDoffre}"),$name );        // Storage::download($file->fichier,$file->titre);
  }
  else {
    Session()->flash('error', "Un erreur c'est produit !!veuillez réessayer");
    return redirect('projets');
  }
 }


    public function fileDownloader1($id)
    {
        $file = Projet::find($id);
        $name = Str::afterLast($file->rapportFinal, 'file/');
        if (Storage::disk('local')->exists($file->rapportFinal)) {
            $user = Auth::user();
            $alerte = collect([
                'type' => 'Download',
                'title' => "Le fichier : '".$name."' du projet ".$file->nom." a été télécharger avec succés",
                'par' => Auth::user()->name . "  " . Auth::user()->prenom,
                'voir' => ''
            ]);
            Notification::send($user, new InvoicePaid($alerte));
            session()->flash('success', "Téléchargement du rapport final..");
            return response()->download(storage_path("app/public/{$file->rapportFinal}"), $name);
            return redirect('projets');
        } else {
            Session()->flash('error', "Un erreur c'est produit !!veuillez réessayer");
            return redirect('projets');
        }
    }
    public function fileViewer1($id)
    {
        $file = Projet::find($id)->fichierDoffre;

        if (Storage::disk('local')->exists($file)) {
            return response()->file('storage/' . $file);
        } else {
            session()->flash('error', "le fichier n'existe pas ");
        }
    }
    public function fileViewer2($id)
    {
        $file = Projet::find($id)->lettreReponse;

        if (Storage::disk('local')->exists($file)) {
            return response()->file('storage/' . $file);
        } else {
            session()->flash('error', "le fichier n'existe pas ");
        }
    }
    public function fileViewer3($id)
    {
        $file = Projet::find($id)->rapportFinal;

        if (Storage::disk('local')->exists($file)) {
            return response()->file('storage/' . $file);
        } else {
            session()->flash('error', "le fichier n'existe pas ");
        }
    }
    public function about($idd)
    {
        $id = Projet::find($idd);
        $groupe = DB::table('delivrables')
                     ->join('users', 'users.id', '=', 'delivrables.id_respo')
                     ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
                     ->join('projets', 'projets.id', '=', 'taches.ID_projet')
                     ->select('users.name', 'users.prenom', 'users.photo','users.id')
                     ->where('taches.ID_projet', '=', $idd)
                     ->get();

        $chefDeGroupe = DB::table('users')
                        ->join('projets','projets.chefDeGroupe','=','users.id')
                        ->select('users.name', 'users.prenom', 'users.photo','users.about')
                        ->where('projets.id','=',$idd)
                        ->first();


        return view('soumissions.about',['membres' => $groupe, 'chefDeGroupe' => $chefDeGroupe,'Projectid' => $id ]);
    }

}
