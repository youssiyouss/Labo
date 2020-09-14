<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Rfp;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\RfpRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Carbon\carbon;
use App\Notifications;
use Illuminate\Support\Facades\Validator;

class RfpController extends Controller
{
      public function __construct()
      {
          $this->middleware('auth');
      }
      public function index(){
          $listeM = DB::table('rfps')
                ->join('clients', 'clients.id', '=', 'rfps.maitreOuvrage')
                ->select('rfps.*', 'clients.ets')
                ->get();
        // foreach ($listeM as $rfp) {
        //   $today = Carbon::now('Africa/Algiers');
        //   $dateEnd = Carbon::parse($rfp->echeance);
        //
        //   $date_diff1=$dateEnd->diffInHours($today);
        //   $date_diff2=$dateEnd->diffInDays($today);
        //   $date_diff3=$today->diffInMinutes($dateEnd);
        //   if ($date_diff3==0) {
        //     Session()->flash('error', "la date d'échéance pour l'RFP :".$rfp->titre." est passée! Cet RFP va etre supprimer définitivment");
        //     $appeldoffre = Rfp::find($rfp);
        //   	$appeldoffre->delete();
        //   }
        //   else if ($date_diff1 == 1) {
        //     Session()->flash('error', "Il reste 1h avant la fin de l'écheance pour l'RFP ".$rfp->titre);
        //   }
        //   else if ($date_diff1 == 24) {
        //     Session()->flash('error', "la date d'écheance pour l'RFP :".$rfp->titre." est pour demain!");
        //   }
        //   else if ($date_diff2 == 7) {
        //     Session()->flash('error', "Il reste 1 semaine avant que l'RFP :".$rfp->titre." expire!");
        //   }
        //   else if ($date_diff2 == 14) {
        //     Session()->flash('error', "Il reste 2 semaine avant que l'RFP :".$rfp->titre." expire!");
        //   }
        //   else if ($date_diff2 == 30) {
        //     Session()->flash('error', "Il reste 1 mois avant que l'RFP :".$rfp->titre." expire!");
        //   }
        //
        // }
   	      return view('rfps.index', ['appeldoffre' =>$listeM]);
      }


    public function show($id)
    {
        $appeldoffre = DB::table('rfps')
            ->join('clients', 'clients.id', '=', 'rfps.maitreOuvrage')
            ->select('rfps.*', 'clients.ets')
            ->first();
        return view('rfps.show', ['rfp' => $appeldoffre ]);
    }


      public function create(){
        $maitreOuvrages = DB::table('clients')
            ->select('clients.id','clients.ets')
            ->orderby('clients.id')
            ->get();
          return view('rfps.create',['mo' => $maitreOuvrages]);
      }


      public function store(RfpRequest $request){
      $appeldoffre = new Rfp();
      $appeldoffre->maitreOuvrage  = $request->input('maitreOuvrage');
      $appeldoffre->titre = $request->input('titre');
      $appeldoffre->type = $request->input('type');
      $appeldoffre->resumer = $request->input('resumer');
      $appeldoffre->dateAppel = $request->input('dateAppel');
      $appeldoffre->dateEcheance = $request->input('dateEcheance');
      $appeldoffre->heureAppel = date("H:i", strtotime(request('heureAppel')));
      $appeldoffre->heureEcheance =date("H:i", strtotime(request('heureEcheance')));
      $appeldoffre->sourceAppel = $request->input('sourceAppel');
     if($request->hasFile('fichier')){
         $fn= $request->input('titre').'.'.$request->fichier->getClientOriginalExtenSion();
      	 $appeldoffre->fichier = $request->fichier->storeAs('file',$fn);
      }

      if ($appeldoffre->save()) {
        Session()->flash('success', "l'RFP : ".$appeldoffre->titre." a été enregistrer avec succées!!");
    } else {
        Session()->flash('error', 'Enregistrement echouée!!');
    }
    return redirect('rfps');


  }

  public function edit($id){
    $appeldoffre = Rfp::find($id);
    $maitreOuvrages = DB::table('clients')
        ->select('clients.id','clients.ets')
        ->orderby('clients.id')
        ->get();

      return view('rfps.edit', ['appeldoffre' =>$appeldoffre,'mo' => $maitreOuvrages]);
      }

  public function update(RfpRequest $request, $id){
      	$appeldoffre = Rfp::find($id);
    //  $appeldoffre->update($request->all());
      $appeldoffre->maitreOuvrage  = $request->input('maitreOuvrage');
      $appeldoffre->titre = $request->input('titre');
      $appeldoffre->type = $request->input('type');
      $appeldoffre->resumer = $request->input('resumer');
      $appeldoffre->dateAppel = $request->input('dateAppel');//date("dd-mm-yyyy", strtoDate(request('dateEcheance')));
      $appeldoffre->dateEcheance =$request->input('dateEcheance');//date("dd-mm-yyyy", strtoDate(request('dateEcheance')));
      $appeldoffre->heureAppel = date("H:i", strtotime(request('heureAppel')));
      $appeldoffre->heureEcheance =date("H:i", strtotime(request('heureEcheance')));
      $appeldoffre->sourceAppel = $request->input('sourceAppel');
     if($request->hasFile('fichier')){
          $fn= $request->input('titre').'.'.$request->fichier->getClientOriginalExtenSion();
          $appeldoffre->fichier = $request->fichier->storeAs('file',$fn);
         }
      if ($appeldoffre->save()) {
          Session()->flash('success', "l'RFP : ".$appeldoffre->titre." a été modifié avec succées!!");
      } else {
          Session()->flash('error', 'Modification échouée!!');
      }

  	return redirect('rfps');
  }

  public function destroy ($id){
    $appeldoffre = Rfp::find($id);
        $this->authorize('delete', $appeldoffre);
    $appeldoffre->delete();
       session()->flash('success', 'le projet : '.$appeldoffre->titre.'a été supprimer définitivement');
    return redirect('rfps');
  }

  public function fileDownloader($id){
     $file= Rfp::find($id);
     $infoPath = pathinfo($file->fichier);
     $extension = $infoPath['extension'];
     $name= "$file->titre".'.'."$extension";
     if (Storage::disk('local')->exists($file->fichier)){

        return response()->download(storage_path("app/public/{$file->fichier}"),$name );
        Session()->flash('success', "l'RFP a été télécharger dans votre ordinateur avec succées!!")->redirect('rfps');
    } else {
         Session()->flash('error', "Un erreur c'est produit !!veuillez réessayer");
        return redirect('rfps');
    }
  }
    public function fileViewer($rfp)
    {
        $file = Rfp::find($rfp)->fichier;

        if (Storage::disk('local')->exists($file)) {
            return response()->file('storage/' . $file);
        } else {
            session()->flash('error', "le fichier n'existe pas ");
        }
    }



}
