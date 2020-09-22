<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Projet;
use App\Livrable;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use Notification;
use carbon\Carbon;


class LivrableController extends Controller
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

        $livrables = Livrable::all();
        $respos = User::all();
        $liste = DB::table('delivrables')
        ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
        ->join('projets', 'projets.id', 'taches.ID_projet')
        ->select('delivrables.*','taches.titreTache', 'taches.description', 'taches.priorite')
        ->where([['taches.ID_projet', '=', $id],
                 ['projets.chefDeGroupe', '=', Auth::user()->id]])
        ->orderBy('delivrables.avancement', 'desc')
        ->groupBy('delivrables.id_respo', 'delivrables.id_tache')
        ->get();
        $unique = $liste->unique('id_tache');
        $unique->values()->all();
        return view('livrables.index', ['livrable' => $unique, 'respo'=>$respos, 'liv' => $livrables,'Projectid' => $id, 'Projectname' => $name]);
    }


    public function mesLivrables($id){
        $id = Projet::find($id)->id;
        $name = Projet::find($id)->nom;

        $liste = DB::table('delivrables')
        ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
        ->join('projets', 'projets.id', 'taches.ID_projet')
        ->select('delivrables.*', 'taches.titreTache', 'taches.priorite')
        ->where([
            ['taches.ID_projet', '=', $id],
            ['delivrables.id_respo', '=', Auth::user()->id]
        ])
        ->orderBy('taches.priorite', 'desc')
        ->groupBy('delivrables.id_tache', 'delivrables.id_respo')
        ->get();
        $unique = $liste->unique('id_tache');

        $unique->values()->all();
         return view('livrables.mesLivrables', ['livrable' => $unique, 'Projectid' => $id, 'Projectname' => $name]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $projet = Projet::find($id)->id;
        $p = Projet::find($id)->nom;
        $chercheurs=  User::all();
        $taches= DB::table('taches')
            ->select('taches.id','taches.titreTache')
            ->where('taches.ID_projet','=',$projet)
            ->get();
            return view('livrables.create', ['ch' => $chercheurs , 't' => $taches , 'projectId'=> $projet,'name'=>$p]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deli = new Livrable();

        $deli->id_respo  = $request->input('id_respo');
        $deli->id_tache =$request->input('id_tache');
        $deli->avancement  = $request->input('avancement');
        $deli->type  = $request->input('type');
        $deli->commentaire  = $request->input('commentaire');
        if($request->hasFile('centenu')){
            $fn= $request->centenu->getClientOriginalName();
              $deli->centenu = $request->centenu->storeAs('file',$fn);
         }
        $projet = DB::table('delivrables')
            ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
            ->select('taches.ID_projet', 'taches.titreTache')
            ->where('taches.id', '=', $request->input('id_tache'))
            ->first();
         if ($deli->save()) {
            $alerte = collect([
                'type' => 'Nouveau livrable',
                'title' => "Vous avez un livrable a rendre pour la tache : '" . $projet->titreTache ."'",
                'id' => $projet->ID_projet,
                'par' => Auth::user()->name . '  ' . Auth::user()->prenom,
                'voir' => 'livrables/MesLivrables/' . $projet->ID_projet
            ]);

            Notification::send($deli->id_respo, new InvoicePaid($alerte));
            Session()->flash('success', "Livrable ajoutée avec success!!");
        } else {
            Session()->flash('error', 'Enregistrement echouée!!');
        }


        return redirect('livrables/'.$projet->ID_projet);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Livrable  $livrable
     * @return \Illuminate\Http\Response
     */
    public function edit($livrable,$id)
    {
        $projet = Projet::find($id)->id;
        $p = Projet::find($id)->nom;
        $policy = DB::table('delivrables')
                    ->select('delivrables.*')
                    ->where([['delivrables.id_respo', '=', Auth::user()->id],['delivrables.id_tache', '=',$livrable]])
                    ->first();

        $this->authorize('update', [Auth::user(),$policy]);
        $tache = DB::table('delivrables')
                ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
                ->select('taches.titreTache')
                ->where([['delivrables.id_tache', '=', $livrable],['delivrables.id_respo','=',Auth::user()->id]])
                ->first();
        $livrables = DB::table('delivrables')
            ->select('delivrables.*')
            ->where('delivrables.id_tache', '=', $livrable)
            ->get();
        //dd($livrables);
        return view('livrables.edit', ['l' => $livrables ,'tache' => $tache,'projectId' => $projet, 'name' => $p]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Livrable  $livrable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$livrable)
    {
        $redirect =  DB::table('delivrables')
                ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
                ->select('taches.titreTache', 'taches.ID_projet')
                ->where('delivrables.id_tache', '=', $livrable)
                ->first();
        $alerte = collect([
            'type' => 'Modifier livrable',
            'title' => "Le livrable de la tache : '" . $redirect->titreTache . "' a été mise a jour! allez le voir",
            'id' => $redirect->ID_projet,
            'par' => Auth::user()->name . '  ' . Auth::user()->prenom,
            'voir' => 'livrables/MesLivrables/' . $redirect->ID_projet
        ]);
        $user = DB::table('delivrables')
            ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
            ->select('delivrables.id_respo', 'delivrables.id_tache')
            ->where('delivrables.id_tache', '=', $livrable)
            ->get();


        foreach ($user as $user) {
            $enrg = DB::table('delivrables')->where([['id_respo', $user->id_respo], ['id_tache', $livrable]])
                ->update(
                    ['type' => $request->input('type'),'avancement' => $request->input('avancement'),'commentaire' => $request->input('commentaire'),'updated_at' =>Carbon::now('Africa/Algiers')]
                );
            if ($request->hasFile('contenu')) {
                $fn = $request->contenu->getClientOriginalName();
                $file = $request->contenu->storeAs('file', $fn);
                DB::table('delivrables')->where([['id_respo', $user->id_respo], ['id_tache', $livrable]])->update(['contenu' => $file]);
            }

        }

        $respos = DB::table('users')
            ->join('delivrables', 'users.id', '=', 'delivrables.id_respo')
            ->select('users.*')
            ->where('delivrables.id_tache', '=', $livrable)
            ->get();
        $chef = User::where('id', '=', $redirect->ID_projet)->first();

            foreach ($respos as $respo) {
                if ($respo->id != Auth::user()->id && $respo->id != $chef->id) {
                    $u = User::get()->where('id', '=', $respo->id);
                    Notification::send($u, new InvoicePaid($alerte));
                }
            }
            Notification::send($chef, new InvoicePaid($alerte));
            if ($enrg) {
                Session()->flash('success', "le livrable de la tache : '" . $redirect->titreTache . "' a été modifiée avec succées!!");
            } else {
                Session()->flash('error', 'Modification echouée!!');
            }
        return redirect('livrables/MesLivrables/'. $redirect->ID_projet);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Livrable  $livrable
     * @return \Illuminate\Http\Response
     */
    public function destroy($livrable)
    {
        $ll=DB::table('taches')
            ->select('taches.titreTache', 'taches.ID_projet')
            ->where('taches.id', '=', $livrable)
            ->first();

        $policy = DB::table('projets')
            ->select('projets.chefDeGroupe','projets.nom')
            ->where('projets.id', '=', $ll->ID_projet)
            ->first();
        $this->authorize('update', [Auth::user(), $policy]);


        $alerte = collect([
            'type' => 'Supprimer tache',
            'title' => "La tache : '" . $ll->titreTache . " ' dont vous avez été assigné a été annuller",
            'id' => $ll->ID_projet,
            'nom' => $policy->nom,
            'par' => Auth::user()->name .'  '. Auth::user()->prenom,
            'voir' => ''
        ]);
        $respos = DB::table('users')
            ->join('delivrables', 'delivrables.id_respo', '=', 'users.id')
            ->select('users.id')
            ->where('delivrables.id_tache', '=', $livrable)
            ->get();
            foreach ($respos as $key => $r) {
                $user = User::find($r->id);
                Notification::send($user, new InvoicePaid($alerte));
            }

        $l= DB::table('delivrables')
            ->select('delivrables.*')
            ->where('delivrables.id_tache', '=', $livrable)
            ->delete();

        if($l){
            session()->flash('success', 'le livrable de la tache :' . $ll->titreTache . ' a été supprimer avec succés');
        }
        else{
            session()->flash('error', 'le livrable de la tache :' .  $ll->titreTache . " n'a pas été supprimer!");

        }
        return redirect('livrables/' . $ll->ID_projet);
    }


    public function fileViewer($livrable){

        $file = DB::table('delivrables')
            ->select('delivrables.contenu')
            ->where('delivrables.id_tache', '=', $livrable)
            ->first();

        if (Storage::disk('local')->exists($file->contenu)) {
            return response()->file('storage/' . $file->contenu);

        }else{
            session()->flash('error', "le fichier n'existe pas ");
        }
    }




    public function fileDownloader($livrable)
    {
        $file = DB::table('delivrables')
                ->select('delivrables.contenu')
                ->where('delivrables.id_tache', '=', $livrable)
                ->first();
        $x=DB::table('delivrables')
                ->join('taches','taches.id' ,'=','delivrables.id_tache')
                ->select('taches.ID_projet','taches.titreTache')
                ->where('taches.id', '=', $livrable)
                ->first();
        $name = Str::afterLast($file->contenu, 'file/');

        if (Storage::disk('local')->exists($file->contenu)) {
            $user = Auth::user();
            $alerte = collect([
                'type' => 'Download',
                'title' => "Le fichier details : '" . $name . "' du livrable " . $x->titreTache . " a été télécharger avec succés",
                'par' => Auth::user()->name . "  " . Auth::user()->prenom,
                'voir' => ''
            ]);
            Notification::send($user, new InvoicePaid($alerte));
            Session()->flash('success', "le fichier a été télécharger dans votre ordinateur avec succées!!");
            return redirect('livrables/' . $x->ID_projet);
            return response()->file('storage/'. $file->contenu);
            return response()->download(storage_path("app/public/{$file->contenu}"), $name);
        } else {
            Session()->flash('error', "Un erreur c'est produit !!veuillez réessayer");
            return redirect('livrables/' . $x->ID_projet);
        }
    }

    public function poke($tache){
        $respos =  User::join('delivrables', 'users.id', '=', 'delivrables.id_respo')
                ->where('delivrables.id_tache', '=', $tache)
                ->get();
        $projet =DB::table('delivrables')
                    ->join('taches', 'taches.id', '=', 'delivrables.id_tache')
                    ->join('projets', 'projets.id', '=', 'taches.ID_projet')
                    ->select('taches.ID_projet','taches.titreTache','projets.nom')
                    ->where('delivrables.id_tache', '=', $tache)
                    ->first();

                $alerte = collect([
                    'type' => 'Poke',
                    'title' => "Besoin de votre livrable pour la tache : '". $projet->titreTache ."' Le plus tot possible",
                    'id' => $projet->ID_projet,
                    'nom' => $projet->nom,
                    'par' => Auth::user()->name.'  '.Auth::user()->prenom ,
                    'voir' => 'livrables/MesLivrables/'. $projet->ID_projet
                ]);

        Notification::send($respos, new InvoicePaid($alerte));
        Session()->flash('success', "Un alerte a été envoyer aux responsable(s)");

     return redirect('livrables/' . $projet->ID_projet);
    }

}
