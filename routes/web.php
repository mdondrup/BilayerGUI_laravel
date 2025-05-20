<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SitemapXmlController;


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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/advanced-search', 'BusquedaAvanzadaController@form')->name('advanced-search.form');
Route::get('/advanced-search/result', 'BusquedaAvanzadaController@results')->name('advanced-search.results');
Route::post('/advanced-search/export', 'BusquedaAvanzadaController@export')->name('advanced-search.export');

// TEST de busqueda avanzada
Route::get('/new-advanced-search', 'NewAdvancedSearchController@form')->name('new_advanced_search.form');
Route::get('/new-advanced-search/result', 'NewAdvancedSearchController@results')->name('new_advanced_search.results');
Route::get('/new-advanced-search/compare', 'NewAdvancedSearchController@compare')->name('new_advanced_search.compare');
Route::post('/new-advanced-search/updatecompare', 'NewAdvancedSearchController@updatecompare')->name('new_advanced_search.updatecompare');
Route::get('/new-advanced-search/export', 'NewAdvancedSearchController@resultsExport')->name('new_advanced_search.resultsExportacion');

Route::get('/new-advanced-search/exportcompare', 'NewAdvancedSearchController@exportarcompare')->name('new_advanced_search.exportarcompare');
// ------
// Estadisticas
Route::get('/statistics', 'StatisticsController@results')->name('statistics.results');
Route::get('/totals', 'StatisticsController@totals')->name('statistics.totals');
// File
Route::get('files/{id}/{file}', 'FileController@download')->name('download');
Route::get('filesp/{id}/{file}', 'FileController@downloadp')->name('downloadp');
Route::get('filesff/{id}/{file}', 'FileController@downloadff')->name('downloadff');

Route::get('/filtro/{codigo}', 'FiltrosController@html')->name('filtros.html');
Route::get('/filtro-busqueda-avanzada/{codigo}/{numero}', 'FiltrosController@htmlBusquedaAvanzada')->name('filtros.html_busqueda_avanzada');
Route::get('/trajectories/{trayectoria_id}', 'TrayectoriasController@show')->name('trayectorias.show');

Route::get('/filtro-busqueda-avanzada-selects/{codigo}/{numero}', 'FiltrosController@htmlBusquedaAvanzadaSelects')->name('filtros.html_busqueda_avanzada_selects');


Route::get('/search', 'SearchController@results')->name('search.results');

// AUTOCOMPLETE
Route::get('/search/basic', 'SearchController@basic')->name('search.basic');


// Esto no sirve
Route::get('convert-pdf-to-image', [ImageController::class, 'index'])->name('form');
Route::get('OptimizeImages', [ImageController::class, 'index'])->name('form');
// ---


Route::get('/sitemap.xml', [SitemapXmlController::class, 'sitemap']);

// Routas para relleno automatico del formulario avanzado.
Route::get('listLipidos', function (Illuminate\Http\Request  $request) {
    $term = $request->term ?: ''; //  <- esto depende del js que lo manda asi
    $tags = App\Lipido::where('short_name', 'like', $term . '%')->lists('short_name', 'id');
    $valid_tags = [];
    foreach ($tags as $id => $tag) {
        $valid_tags[] = ['id' => $id, 'text' => $tag];
    }
    return \Response::json($valid_tags);
});

// Route::get('/peptido/{peptido_id}', 'PeptidosController@show')->name('peptidos.show');
// Route::get('/lipido/{lipido_id}', 'LipidosController@show')->name('lipidos.show');
// ion
// agua
// molecula

// resultado buscador
