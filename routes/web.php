<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\FacturesController;
use App\Http\Controllers\clientController;
use App\Http\Controllers\homecontroller;

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




Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
// new proposal 
Route::get('/', [homecontroller::class, 'homepage'])->name('home');
Route::get('/devis', [homecontroller::class, 'devis'])->name('devis');
Route::get('/devis/nouveau/', [homecontroller::class, 'newdevis'])->name('newdevis');
Route::get('/devis/{id}', [homecontroller::class, 'add_article_devis'])->name('add_article_devis');
Route::post('/devis/new/', [homecontroller::class, 'adddevis'])->name('adddevis');
Route::post('/ajouter/article/', [homecontroller::class, 'addarticle'])->name('addarticle');
Route::post('/supprimer/article', [homecontroller::class, 'deletearticle'])->name('deletearticle');
Route::post('/confirmer/panier', [homecontroller::class, 'panierenv'])->name('panierenv');

/*
Route::get('/clients', [clientController::class, 'index'])->name('allclient');
Route::get('/clients/show/{id}', [clientController::class, 'client']);
Route::get('/dossiers/show/{id}', [DossierController::class, 'dossier']);
Route::get('/dossiers/new/{id}', [DossierController::class, 'newdossierclient']);
Route::get('/dossiers/new', [DossierController::class, 'newdossier']);
Route::post('/newdossier', [DossierController::class, 'creedossier']);
Route::get('/factures/show/{id}', [FacturesController::class, 'factures']);
Route::get('/new/debours', [DossierController::class, 'newdebours']);
Route::get('/factures', [FacturesController::class, 'index']);
Route::get('/client/new', [clientController::class, 'newclient']);
Route::post('/client/new', [clientController::class, 'addclient']);
*/
Route::group(['prefix' => 'dossiers'], function () {
    Route::get('/', [DossierController::class, 'index']);
});
