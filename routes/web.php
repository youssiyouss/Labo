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
Auth::routes(['register' => false]);

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home','Controller@home');

//chercheurs
Route::resource('chercheurs','UserController');

//rfps
Route::resource('rfps','RfpController');
Route::get('rfps/dowlaodRfp/{id}','RfpController@fileDownloader');
Route::get('rfps/voir/{id}', 'RfpController@fileViewer');

//soumissions
Route::resource('projets','ProjetController');
Route::get('projets/dowlaodProjet/{id}','ProjetController@fileDownloader');
Route::get('projets/voir/{id}', 'ProjetController@fileViewer');

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



// Route::group(['prefix' => 'email'], function(){
//     Route::get('inbox', function () { return view('pages.email.inbox'); });
//     Route::get('read', function () { return view('pages.email.read'); });
//     Route::get('compose', function () { return view('pages.email.compose'); });
// });
//
// Route::group(['prefix' => 'apps'], function(){
//     Route::get('chat', function () { return view('pages.apps.chat'); });
//     Route::get('calendar', function () { return view('pages.apps.calendar'); });
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
