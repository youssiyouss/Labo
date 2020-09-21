<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Canvas;
use Auth;
use App\Notifications\InvoicePaid;
use Notification;
use Illuminate\Support\Facades\Storage;

class CanvasController extends Controller
{

    public function index()
    {
        $x = Canvas::all();

        return view('canvas.index', ['canvas' => $x]);
    }


    public function store(Request $request)
    {
        $c = new Canvas();
        $c->pour  = $request->input('pour');
        if ($request->hasFile('canvas')) {
            $fn = $request->input('pour').'-Canvas.'.$request->canvas->getClientOriginalExtenSion();
            $c->canvas = $request->canvas->storeAs('file', $fn);
        }

        if ($c->save()) {
            Session()->flash('success', "le canvas pour : ".$c->pour." a été ajouter avec succés!!");
            $user = auth()->User()->all();
            $alerte = collect([
                'type' => 'Canvas',
                'title' => 'Un canvas standard pour les projets :'.$c->pour.' a été ajouter',
                'par' => Auth::user()->name . "  " . Auth::user()->prenom,
                'voir' => 'canvas'
            ]);
            Notification::send($user, new InvoicePaid($alerte));
        } else {
            Session()->flash('error', 'Enregistrement echouée!!');
        }
        return redirect('canvas');
    }



    public function update(Request $request,$id)
    {
        $c = Canvas::find($id);

        $c->pour  = $request->input('pour');
        if ($request->hasFile('canvas')) {
            $fn = $request->input('pour') . '-Canvas.' . $request->canvas->getClientOriginalExtenSion();
            $c->canvas = $request->canvas->storeAs('file', $fn);
        }

        if ($c->save()) {
            Session()->flash('success', "le canvas pour : " . $c->pour . " a été ajouter avec succés!!");
            $user = auth()->User()->all();
            $alerte = collect([
                'type' => 'Canvas',
                'title' => 'Le canvas standard pour les projets :' . $c->pour . ' a été modifié',
                'par' => Auth::user()->name . "  " . Auth::user()->prenom,
                'voir' => 'canvas'
            ]);
            Notification::send($user, new InvoicePaid($alerte));
        } else {
            Session()->flash('error', 'Enregistrement echouée!!');
        }
        return redirect('canvas');
    }

    public function destroy($id)
    {
        $c = Canvas::find($id);
        //$this->authorize('delete', $c);
        $c->delete();
        session()->flash('success', "le canvas pour : " . $c->pour . " a été supprimé avec succés!!");
        $user = auth()->User()->all();
        $alerte = collect([
            'type' => 'Canvas',
            'title' => 'Le canvas standard pour les projets :' . $c->pour . ' a été supprimé',
            'par' => Auth::user()->name . "  " . Auth::user()->prenom,
            'voir' => 'canvas'
        ]);
        Notification::send($user, new InvoicePaid($alerte));
        return redirect('canvas');
    }
    public function fileDownloader($id)
    {
        $file = Canvas::find($id);
        $infoPath = pathinfo($file->canvas);
        $extension = $infoPath['extension'];
        $name = "$file->pour".'-Canvas.'."$extension";
        if (Storage::disk('local')->exists($file->canvas)) {

            return response()->download(storage_path("app/public/{$file->canvas}"), $name);
            Session()->flash('success', "le canvas standard a été télécharger dans votre ordinateur avec succés!!");
            $user = Auth::user();
            $alerte = collect([
                'type' => 'Download',
                'title' => "Le canvas standard du projets: '" . $file->pour . " a été télécharger avec succès",
                'par' => Auth::user()->name . "  " . Auth::user()->prenom,
                'voir' => ''
            ]);
            Notification::send($user, new InvoicePaid($alerte));

            return redirect('canvas');
        } else {
            Session()->flash('error', "Un erreur c'est produit !!veuillez réessayer");
            return redirect('canvas');
        }
    }
}
