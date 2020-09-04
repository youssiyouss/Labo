<?php

namespace App\Http\Controllers;
use App\Tache;
use App\Projet;
use App\Delivrable;
use Illuminate\Support\Facades\DB;
use auth;
use Illuminate\Http\Request;

class DelivrableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $chercheurs= DB::table('users')
            ->select('users.id','users.name','users.prenom')
            ->get();
        $taches= DB::table('taches')
            ->select('taches.ID_projet','taches.id','taches.titreTache')
            ->where('taches.ID_projet','=',$projet)
            ->get();
            return view('delivrables.create', ['ch' => $chercheurs , 't' => $taches , 'name'=>$p]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $deli = new Delivrable();

        $deli->id_respo  = $request->input('id_respo');
        $deli->id_tache =$request->input('id_tache');
        $deli->avancement  = $request->input('avancement');
        $deli->commentaire  = $request->input('description');
        if($request->hasFile('centenu')){
            $fn= $request->centenu->getClientOriginalName();
              $deli->centenu = $request->centenu->storeAs('file',$fn);
         }
         if ($deli->save()) {

            Session()->flash('success', "la tache a été completée!!");
        } else {
            Session()->flash('error', 'Enregistrement echouée!!');
        }
        return redirect('delivrables');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Delivrable  $delivrable
     * @return \Illuminate\Http\Response
     */
    public function show(Delivrable $delivrable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Delivrable  $delivrable
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivrable $delivrable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Delivrable  $delivrable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivrable $delivrable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Delivrable  $delivrable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivrable $delivrable)
    {
        //
    }
}
