<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index() {
    $x = DB::table('clients')
          ->leftjoin('rfps', 'clients.id', '=', 'rfps.maitreOuvrage')
          ->leftjoin('projets', 'rfps.id', '=', 'projets.ID_rfp')
          ->select(DB::raw('count(projets.ID_rfp)as NmbrContratActives,count(rfps.maitreOuvrage) as NmbrContrat, clients.*'))
          ->groupBy('clients.id')
          ->get();

    return view('clients.index',['client'=>$x]);
  }

  public function create() {
      return view('clients.create');
  }

  public function store(ClientRequest $request) {
      $x = new Client();
      $x->ets= $request->input('ets');
      $x->pays = $request->input('pays');
      $x->ville = $request->input('ville');
      $x->tel = $request->input('tel');
      $x->adresse = $request->input('adresse');
      $x->site = $request->input('site');
      $x->email = $request->input('email');

      $x->save();
    session()->flash('success',"{$x->ets} a été ajoutés avec succés!");
    return redirect('clients');
  }

  public function edit($id) {
    $x = Client::find($id);
    return view('clients.edit',['client'=>$x]);
  }

  public function update(ClientRequest $request,$id) {
    $x = Client::find($id);
    $x->ets= $request->input('ets');
    $x->tel = $request->input('tel');
    $x->adresse = $request->input('adresse');
    $x->pays = $request->input('pays');
    $x->ville = $request->input('ville');
    $x->site = $request->input('site');
    $x->email = $request->input('email');
    if ($x->save()) {
        Session()->flash('success', "le client : ".$x->ets."a été modifié avec succés");
        } else {
        Session()->flash('error', 'Modification echouée!!');
        }

        return redirect('clients');
  }

  public function destroy(Request $request , $id) {
    $x = Client::find($id);
        $this->authorize('delete', $x);
    $x->delete();
    session()->flash('success',"{$x->ets} a été supprimer avec succés");
    return redirect('clients');
  }

}
