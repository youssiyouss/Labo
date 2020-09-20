<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function home(){

        $projects= DB::table('projets')
                ->join('users','users.id','=','projets.chefDeGroupe')
                ->join('rfps', 'rfps.id', '=', 'projets.ID_rfp')
                ->select('projets.*','users.name','users.prenom','rfps.titre')
                ->where('projets.reponse','=','Accepté')
                ->orWhere('projets.reponse', '=', 'Accepté avec reserve')
                ->get();

        return view('dashboard',['projet' => $projects]);
    }


}
