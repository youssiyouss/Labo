<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Tache;
use App\Projet;
use App\Livrable;
use App\User;
use App\Http\Requests\TacheRequest;
use Illuminate\Support\Facades\DB;
use auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use Notification;

class TacheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index($id)
    {
      $id = Projet::find($id)->id;
      $name = Projet::find($id)->nom;
      $chefG=Projet::find($id)->chefDeGroupe;
      $this->authorize('viewAny',[Tache::class,$chefG]);
        $livrables = Livrable::all();
        $respos = User::all();
      $liste = DB::table('taches')
      ->join('projets', 'projets.id', '=', 'taches.ID_projet')
      ->select('taches.*')
      ->where('projets.id','=', $id)
      ->get();

        return view('taches.index', ['taches' => $liste, 'respo' => $respos, 'liv' => $livrables, 'Projectid' =>$id,'Projectname' =>$name ]);
    }

    public function mesTaches($id){
        $id = Projet::find($id)->id;
        $name = Projet::find($id)->nom;


        $liste = DB::table('delivrables')
        ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
        ->join('users', 'users.id', '=', 'delivrables.id_respo')
        ->join('projets', 'projets.id', '=', 'taches.ID_projet')
        ->select('taches.*', 'projets.nom', 'delivrables.avancement')
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
      $chercheurs= User::all()->unique('email');
      $chefG=Projet::find($id)->chefDeGroupe;
      $this->authorize('create',[Tache::class,$chefG]);
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
      $tache->dateFin = $request->input('dateFin');
      if($request->input('dateDebut') == NULL){
          $tache->dateDebut = Carbon::now();}
      else{
          $tache->dateDebut = $request->input('dateDebut');
        }
      if($request->hasFile('fichierDetail')){
         $fn= $request->fichierDetail->getClientOriginalName();
      	 $tache->fichierDetail = $request->fichierDetail->storeAs('file',$fn);
      }

      if ($tache->save()) {
          if( $request->input('ID_chercheur', array()))
          {
            $respos =  $request->input('ID_chercheur', array());
            $alerte = collect([
                    'type' => 'Nouveau livrable',
                    'title' => "Vous avez une nouvelle tache assignée : '" . $projet->titreTache . "'",
                    'id' => $projet,
                    'par' => Auth::user()->name . '  ' . Auth::user()->prenom,
                    'voir' => 'taches/MesTaches/'.$projet
                ]);
                Notification::send($request->input('ID_chercheur', array()), new InvoicePaid($alerte));
            foreach ($respos as $key => $ch) {
                $deli = new Livrable();
                $deli->id_respo  =$ch;
                $deli->id_tache =$tache->id;
                $deli->avancement ="Non entamé";
                $deli->save();

            }



          }
        Session()->flash('success', "la tache : ".$tache->titreTache." a été crée avec succées!!");
    } else {
        Session()->flash('error', 'Enregistrement echouée!!');
    }
    return redirect('taches/'.$tache->ID_projet);

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
        $chercheurs =  User::all();

        $respo = DB::table('delivrables')
        ->join('users','users.id','=','delivrables.id_respo')
        ->select('delivrables.*','users.name','users.prenom','users.id')
        ->where('delivrables.id_tache', '=', $tache)
        ->get();

        return view('taches.edit', ['chrch' => $chercheurs ,'respo' => $respo ,'t' => $t]);

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
        $tache->description = $request->input('description');
        $tache->dateDebut = $request->input('dateDebut');
        $tache->dateFin = $request->input('dateFin');
        $tache->priorite = $request->input('priorite');
        if($request->hasFile('fichierDetail')){
         $fn= $request->fichierDetail->getClientOriginalName();
      	 $tache->fichierDetail = $request->fichierDetail->storeAs('file',$fn);
        }
        $p = DB::table('users')
            ->join('delivrables', 'delivrables.id_respo', 'users.id')
            ->select('users.*')
            ->where('id_tache', '=', $tache->id)
            ->get();

            if ($tache->save()){
             $xx=DB::table('delivrables')
                            ->select('delivrables.*')
                            ->where('id_tache','=',$tache->id)
                            ->get(); //le premier responsables de la tache courante

            $user = $xx->first();

            $xx=count($xx);
            $alerte2 = collect([
                'type' => 'Nouveau livrable',
                'title' => "La tache : '" . $tache->titreTache . "' a été réassignée !",
                'id' => $tache->ID_projet,
                'par' => Auth::user()->name . '  ' . Auth::user()->prenom,
                'voir' => 'taches/MesTaches/' . $tache->ID_projet
            ]);

            foreach ($p as $oldRespos) {
                Notification::send(User::find($oldRespos->id), new InvoicePaid($alerte2));
            }
            DB::table('delivrables')->where('id_tache', '=', $tache->id)->delete(); // supprimer tous les livrable pour cette tache

            $respos =  $request->input('ID_chercheur', array());
            $alerte = collect([
                'type' => 'Nouveau livrable',
                'title' => "Vous avez une nouvelle tache assignée : '" . $tache->titreTache . "'",
                'id' => $tache->ID_projet,
                'par' => Auth::user()->name . '  ' . Auth::user()->prenom,
                'voir' => 'taches/MesTaches/'.$tache->ID_projet
            ]);

            foreach ($respos as $key => $ch) { //pour chaque membre sellectionner :
              if($xx <> 0){
                    DB::table('delivrables')->insert(                                       //et créer des nouveau
                        ['id_respo' => $ch,'id_tache' => $tache->id,
                        'type' => $user->type,'avancement' => $user->avancement,
                        'commentaire' => $user->commentaire,'contenu' =>$user->contenu
                        ]);
                    Notification::send(User::find($ch), new InvoicePaid($alerte));

                    }


              else{
                 $deli = new Livrable();
                          $deli->id_respo  = $ch;
                          $deli->id_tache = $tache->id;
                          $deli->avancement = "Non entamé";
                          $deli->save();
                    Notification::send(User::find($ch), new InvoicePaid($alerte));
              }
            }

        Session()->flash('success', "la tache : '".$tache->titreTache."' a été modifiée avec succées!!");
        } else {
        Session()->flash('error', 'Modification echouée!!');
        }
        return redirect('taches/'.$tache->ID_projet);
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
      session()->flash('success', 'la tache '.$tache->titreTache. ' a été supprimer définitivement');
      return redirect('taches/'.$tache->ID_projet);
    }

    public function fileViewer($livrable)
    {

        $file = Tache::find($livrable)->fichierDetail;

        if (Storage::disk('local')->exists($file)) {
            return response()->file('storage/' . $file);
        } else {
            session()->flash('error', "le fichier n'existe pas ");
        }
    }


    public function fileDownloader($id){

      $file= Tache::find($id);
       $infoPath = pathinfo($file->fichierDetail);
       $extension = $infoPath['extension'];
       $name = Str::afterLast($file->fichierDetail, 'file/');
    //   print_r($extension);

       if (Storage::disk('local')->exists($file->fichierDetail)){
           $user = Auth::user();
           $alerte = collect([
               'type' => 'Download',
               'title' => "Le fichier details : '".$name . "' de la tache  " . $file->titreTache . " a été télécharger avec succés",
               'par' => Auth::user()->name . "  " . Auth::user()->prenom,
               'voir' => ''
           ]);
           Notification::send($user, new InvoicePaid($alerte));
           Session()->flash('success', "le fichier a été télécharger dans votre ordinateur avec succées!!");
           return redirect('taches/' . $file->ID_projet);
           return response()->download(storage_path("app/public/{$file->fichierDetail}"),$name );
      } else {
        Session()->flash('error', "Un erreur c'est produit !!veuillez réessayer");
        return redirect('taches/' . $file->ID_projet);
      }

     }
}
