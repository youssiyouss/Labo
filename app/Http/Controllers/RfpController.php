<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Rfp;
use Notification;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use App\Http\Requests\RfpRequest;
use Illuminate\Support\Facades\Storage;
use Carbon\carbon;
use Auth;

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
                ->orderBy('rfps.created_at','desc')
                ->get();
         foreach ($listeM as $rfp) {
           $today = Carbon::now('Africa/Algiers');
           $dateEnd = Carbon::parse($rfp->dateEcheance, 'Africa/Algiers');
           $x= Carbon::parse(now()->timestamp);
           $user = auth()->User()->all();

           //Quand la date d'écheance arrive
           if ($dateEnd->diffInDays($today)==0 && $x->diffInMinutes($rfp->heureEcheance) ==60) {
                $alerte = collect([
                    'type' => 'echeance',
                    'title' => "L'RFP :". $rfp->titre. "  est supprimer définitivement !",
                    'id' => $rfp->id,
                    'nom' => $rfp->titre,
                    'par' => 'LRIT',
                    'voir' => ''
                ]);
             Notification::send($user, new InvoicePaid($alerte));
           	RFP::find($rfp->id)->delete();
           }
            //Quand il reste 2h avant la date d'écheance
            else if ($dateEnd->diffInDays($today) == 0 && $x->diffInHours($rfp->heureEcheance) == 2) {
                $alerte = collect([
                    'type' => 'echeance',
                    'title' => "Il reste 2h avant que l'RFP :" . $rfp->titre . "va etre supprimer définitivement !",
                    'id' => $rfp->id,
                    'nom' => $rfp->titre,
                    'par' => 'LRIT',
                    'voir' => 'rfps/' . $rfp->id
                ]);
                Notification::send($user, new InvoicePaid($alerte));
           }
          //Quand il reste 1 jour avant la date d'écheance
            else if ($dateEnd->diffInDays($today) == 1) {
                $alerte = collect([
                    'type' => 'echeance',
                    'title' => "Il reste 1 jour avant que l'RFP :" . $rfp->titre . "va etre supprimer définitivement !",
                    'id' => $rfp->id,
                    'nom' => $rfp->titre,
                    'par' => 'LRIT',
                    'voir' => 'rfps / ' . $rfp->id
                ]);
                Notification::send($user, new InvoicePaid($alerte));
           }
            //Quand il reste 7 jours avant la date d'écheance
            else if ($dateEnd->diffInDays($today) == 7) {
                $alerte = collect([
                    'type' => 'echeance',
                    'title' => "Il reste 1 semaine avant que l'RFP :" . $rfp->titre . "va etre supprimer définitivement !",
                    'id' => $rfp->id,
                    'nom' => $rfp->titre,
                    'par' => 'LRIT',
                    'voir' => 'rfps/' . $rfp->id
                ]);
                Notification::send($user, new InvoicePaid($alerte));
           }

         }

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
            $user = auth()->User()->all();
            $alerte = collect([
                               'type' => 'Nouveau RFP',
                               'title' => 'Nouveau RfP soumis :' . $appeldoffre->titre,
                               'id' => $appeldoffre->id,
                               'nom' => $appeldoffre->titre,
                               'par' => Auth::user()->name . "  " . Auth::user()->prenom,
                               'voir' => 'rfps/'. $appeldoffre->id]);
            Notification::send($user, new InvoicePaid($alerte));

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
            $user = auth()->User()->all();
            $alerte = collect([
                'type' => 'Modifier RFP',
                'title' => "Modification de l'RFP : ".$appeldoffre->titre,
                'id' => $appeldoffre->id,
                'nom' => $appeldoffre->titre,
                'par' =>  Auth::user()->name."  ".Auth::user()->prenom ,
                'voir' => 'rfps/' . $appeldoffre->id
            ]);
            Notification::send($user, new InvoicePaid($alerte));
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
        $user = auth()->User()->all();
        $alerte = collect([
            'type' => 'Supprimer RFP',
            'title' => "Suppression de l'RFP : " . $appeldoffre->titre,
            'id' => $appeldoffre->id,
            'nom' => $appeldoffre->titre,
            'par' => Auth::user()->name . "  " . Auth::user()->prenom,
            'voir' => ''
        ]);
        Notification::send($user, new InvoicePaid($alerte));
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
