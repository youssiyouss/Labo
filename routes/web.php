<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Authentification :
use App\Email;
use App\User;
use App\Canvas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Auth::routes(['register' => false]);

Route::get('/', 'Controller@home');
// return view('auth.login');


Route::get('/home','Controller@home');

//chercheurs
Route::resource('chercheurs','UserController');

//rfps
Route::resource('rfps','RfpController');
Route::get('rfps/dowlaodRfp/{id}','RfpController@fileDownloader');
Route::get('rfps/voir/{id}', 'RfpController@fileViewer');

Route::get('rfps/dowlaodCanvas/{id}', 'RfpController@CanvasDownloader');


//canvas
Route::resource('canvas', 'CanvasController');
Route::get('canvas/dowlaodCanvas/{id}', 'CanvasController@fileDownloader');


//soumissions
Route::resource('projets','ProjetController');
Route::get('projets/dowlaodProjet/{id}', 'ProjetController@fileDownloader');
Route::get('projets/dowlaodProjet1/{id}','ProjetController@fileDownloader1');
Route::get('projets/voir1/{id}', 'ProjetController@fileViewer1');
Route::get('projets/voir2/{id}', 'ProjetController@fileViewer2');
Route::get('projets/voir3/{id}', 'ProjetController@fileViewer3');
Route::get('projets/about/{id}', 'ProjetController@about');


//Maitre ouvrages
Route::resource('clients','ClientController');

//Taches
Route::get('taches/{id}','TacheController@show');
Route::get('taches/{id}/show','TacheController@show');
Route::get('taches','TacheController@index');
Route::get('taches/create/{id}','TacheController@create');
Route::post('taches/{id}','TacheController@store');
Route::get('taches/{id}/edit','TacheController@edit');
Route::put('taches/{id}','TacheController@update');
Route::delete('taches/{id}','TacheController@destroy');

Route::get('taches/downloadTache/{id}','TacheController@fileDownloader');
Route::get('taches/voir/{id}', 'TacheController@fileViewer');
Route::get('taches/{id}','TacheController@index');
Route::get('taches/MesTaches/{id}','TacheController@mesTaches');


//Livrables
Route::get('livrables/{id}', 'livrableController@show');
Route::get('livrables/{id}/show', 'livrableController@show');
Route::get('livrables', 'livrableController@index');
Route::get('livrables/create/{id}', 'livrableController@create');
Route::post('livrables', 'livrableController@store');
Route::get('livrables/{id}/edit/{projet}', 'livrableController@edit');
Route::put('livrables/{id}', 'livrableController@update');
Route::delete('livrables/{id}', 'livrableController@destroy');

Route::get('livrables/downloadLivrables/{id}', 'livrableController@fileDownloader');
Route::get('livrables/voir/{id}', 'livrableController@fileViewer');

Route::get('livrables/{id}', 'livrableController@index');
Route::get('livrables/MesLivrables/{id}', 'livrableController@mesLivrables');

//Notifications
Route::get('alerte', 'NotificationController@index');
Route::get('readNotification/{id}', 'NotificationController@readNotification');
Route::get('alerte/clearAll', 'NotificationController@clearAll');
Route::delete('alerte', 'NotificationController@destroyAll');
Route::delete('alerte/{id}', 'NotificationController@delete');
//Envoyer un poke
Route::get('livrables/poke/{tache}', 'LivrableController@poke');

//Search
Route::any('search', function(Request $request)  {
    $q = $request->input('search');

    $users = User::where('name', 'LIKE', '%' . $q . '%')->orWhere('prenom', 'LIKE', '%' . $q . '%')->orWhere('grade', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->get();
    $canvas = Canvas::where('pour', 'LIKE', '%' . $q . '%')->get();
    $rfps = DB::table('rfps')
                ->join('clients', 'clients.id', '=', 'rfps.maitreOuvrage')
                ->select('rfps.*', 'clients.ets')
                ->orderBy('rfps.created_at','desc')
                ->where('titre', 'LIKE', '%' . $q . '%')->orWhere('dateEcheance', 'LIKE', '%' . $q . '%')->orWhere('type', 'LIKE', '%' . $q . '%')->orWhere('sourceAppel', 'LIKE', '%' . $q . '%')
                ->get();
    $projets = DB::table('projets')
                ->join('users', 'users.id', '=', 'projets.chefDeGroupe')
                ->select('projets.*', 'users.name', 'users.prenom', 'users.photo')
                ->orderBy('projets.chefDeGroupe')
                ->where('nom', 'LIKE', '%' . $q . '%')->orWhere('plateForme', 'LIKE', '%' . $q . '%')->orWhere('reponse', 'LIKE', '%' . $q . '%')
                ->get();
    $clients = DB::table('clients')
                ->leftjoin('rfps', 'clients.id', '=', 'rfps.maitreOuvrage')
                ->leftjoin('projets', 'rfps.id', '=', 'projets.ID_rfp')
                ->select(DB::raw('count(projets.ID_rfp)as NmbrContratActives,count(rfps.maitreOuvrage) as NmbrContrat, clients.*'))
                ->groupBy('clients.id')
                ->where('ets', 'LIKE', '%' . $q . '%')->orWhere('adresse', 'LIKE', '%' . $q . '%')->orWhere('email', 'LIKE', '%' . $q . '%')->orWhere('ville', 'LIKE', '%' . $q . '%')->orWhere('pays', 'LIKE', '%' . $q . '%')
                ->get();

    return view('search')->with([
            'users' => $users,
            'clients' => $clients,
            'rfps' => $rfps,
            'canvas' => $canvas,
            'projets' => $projets,

        ]);
});




Route::get('email/inbox','EmailController@inbox');
Route::get('email/inboxSent', 'EmailController@inboxSent');
Route::get('email/read/{id}', 'EmailController@read');
Route::get('email/compose/{id}','EmailController@compose');
Route::get('email/compose/{id}/{email}', 'EmailController@compose');
Route::delete('email/{id}','EmailController@destroy');
Route::post('email', 'EmailController@store');
Route::post('email/transfer/{id}', 'EmailController@transfer');
Route::get('email/markAsRead/{id}', 'EmailController@markAsRead');
Route::get('email/markAsUnread/{id}', 'EmailController@markAsUnread');
Route::get('email/clearAll/{id}', 'EmailController@clearAll');
Route::delete('email/deleteAll/{id}', 'EmailController@deleteAll');
Route::get('email/tags/{id}', 'EmailController@tags');

Route::any('mailSearch', function(Request $request)  {
    $q = $request->input('MailSearch');

    $emails = DB::table('emails')
    ->join('users', 'users.email', 'emails.from')
    ->select('users.name', 'users.prenom', 'users.photo', 'emails.*')
    ->where([['to', Auth::user()->email],['message', 'LIKE', '%'.$q.'%']])
    ->orWhere([['to', Auth::user()->email],['subject', 'LIKE', '%'.$q.'%']])
    ->orWhere([['to', Auth::user()->email],['tag', 'LIKE', '%'.$q.'%']])
    ->orWhere([['from', Auth::user()->email],['message', 'LIKE', '%'.$q.'%']])
    ->orWhere([['from', Auth::user()->email],['subject', 'LIKE', '%'.$q.'%']])
    ->orWhere([['from', Auth::user()->email],['tag', 'LIKE', '%'.$q.'%']])
    ->orderBy('created_at','desc')
    ->get();
    $newMail = Email::where([['read_at', Null],['to',Auth::user()->email]])->get();
    $important = DB::table('emails')
    ->select('emails.*')
    ->where([['tag', 'Important'], ['to', Auth::user()->email]])
        ->count();
    return view('emails.inbox')->with([
            'content' => $emails,
            'unreadMails' => $newMail,
            'important' => $important
        ]);
});



//Route::group(['prefix' => 'apps'], function(){
    // Route::get('chat', function () { return view('pages.apps.chat'); });
  //   Route::get('calendar', function () { return view('pages.apps.calendar'); });
// });
//
// Route::group(['prefix' => 'ui-components'], function(){
//     Route::get('alerts', function () { return view('pages.ui-components.alerts'); });
//     Route::get('badges', function () { return view('pages.ui-components.badges'); });
//     Route::get('breadcrumbs', function () { return view('pages.ui-components.breadcrumbs'); });
//     Route::get('buttons', function () { return view('pages.ui-components.buttons'); });
//     Route::get('button-group', function () { return view('pages.ui-components.button-group'); });
//     Route::get('cards', function () { return view('pages.ui-components.cards'); });
//     Route::get('carousel', function () { return view('pages.ui-components.carousel'); });
//     Route::get('collapse', function () { return view('pages.ui-components.collapse'); });
//     Route::get('dropdowns', function () { return view('pages.ui-components.dropdowns'); });
//     Route::get('list-group', function () { return view('pages.ui-components.list-group'); });
//     Route::get('media-object', function () { return view('pages.ui-components.media-object'); });
//     Route::get('modal', function () { return view('pages.ui-components.modal'); });
//     Route::get('navs', function () { return view('pages.ui-components.navs'); });
//     Route::get('navbar', function () { return view('pages.ui-components.navbar'); });
//     Route::get('pagination', function () { return view('pages.ui-components.pagination'); });
//     Route::get('popovers', function () { return view('pages.ui-components.popovers'); });
//     Route::get('progress', function () { return view('pages.ui-components.progress'); });
//     Route::get('scrollbar', function () { return view('pages.ui-components.scrollbar'); });
//     Route::get('scrollspy', function () { return view('pages.ui-components.scrollspy'); });
//     Route::get('spinners', function () { return view('pages.ui-components.spinners'); });
//     Route::get('tabs', function () { return view('pages.ui-components.tabs'); });
//     Route::get('tooltips', function () { return view('pages.ui-components.tooltips'); });
// });
//
// Route::group(['prefix' => 'advanced-ui'], function(){
//     Route::get('cropper', function () { return view('pages.advanced-ui.cropper'); });
//     Route::get('owl-carousel', function () { return view('pages.advanced-ui.owl-carousel'); });
//     Route::get('sweet-alert', function () { return view('pages.advanced-ui.sweet-alert'); });
// });
//
// Route::group(['prefix' => 'forms'], function(){
//     Route::get('basic-elements', function () { return view('pages.forms.basic-elements'); });
//     Route::get('advanced-elements', function () { return view('pages.forms.advanced-elements'); });
//     Route::get('editors', function () { return view('pages.forms.editors'); });
//     Route::get('wizard', function () { return view('pages.forms.wizard'); });
// });
//
// Route::group(['prefix' => 'charts'], function(){
//     Route::get('apex', function () { return view('pages.charts.apex'); });
//     Route::get('chartjs', function () { return view('pages.charts.chartjs'); });
//     Route::get('flot', function () { return view('pages.charts.flot'); });
//     Route::get('morrisjs', function () { return view('pages.charts.morrisjs'); });
//     Route::get('peity', function () { return view('pages.charts.peity'); });
//     Route::get('sparkline', function () { return view('pages.charts.sparkline'); });
// });
//
// Route::group(['prefix' => 'tables'], function(){
//     Route::get('basic-tables', function () { return view('pages.tables.basic-tables'); });
//     Route::get('data-table', function () { return view('pages.tables.data-table'); });
// });
//
// Route::group(['prefix' => 'icons'], function(){
//     Route::get('feather-icons', function () { return view('pages.icons.feather-icons'); });
//     Route::get('flag-icons', function () { return view('pages.icons.flag-icons'); });
//     Route::get('mdi-icons', function () { return view('pages.icons.mdi-icons'); });
// });
//
// Route::group(['prefix' => 'general'], function(){
//     Route::get('blank-page', function () { return view('pages.general.blank-page'); });
//     Route::get('faq', function () { return view('pages.general.faq'); });
//     Route::get('invoice', function () { return view('pages.general.invoice'); });
//     Route::get('profile', function () { return view('pages.general.profile'); });
//     Route::get('pricing', function () { return view('pages.general.pricing'); });
//     Route::get('timeline', function () { return view('pages.general.timeline'); });
// });
//
// Route::group(['prefix' => 'auth'], function(){
//     Route::get('login', function () { return view('pages.auth.login'); });
//     Route::get('register', function () { return view('pages.auth.register'); });
// });
//
Route::group(['prefix' => 'error'], function(){
    Route::get('404', function () { return view('errors.404'); });
    Route::get('500', function () { return view('errors.500'); });
    Route::get('403', function () { return view('errors.403'); });
});
//
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// 404 for undefined routes
Route::any('/{page?}',function(){
    return View::make('errors.404');
})->where('page','.*');
