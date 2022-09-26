<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\FacturesController;
use App\Http\Controllers\clientController;

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
});



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::get('/clients', [clientController::class, 'index']);
Route::get('/clients/show/{id}', [clientController::class, 'client']);
Route::get('/dossiers/show/{id}', [DossierController::class, 'dossier']);
Route::get('/dossiers/new/{id}', [DossierController::class, 'newdossierclient']);
Route::get('/dossiers/new', [DossierController::class, 'newdossier']);
Route::post('/newdossier', [DossierController::class, 'creedossier']);
Route::get('/factures/show/{id}', [FacturesController::class, 'factures']);
Route::get('/new/debours', [DossierController::class, 'newdebours']);
Route::get('/factures', [FacturesController::class, 'index']);
Route::get('/client/new', [clientController::class, 'newclient']);

Route::group(['prefix' => 'dossiers'], function () {
    Route::get('/', [DossierController::class, 'index']);
});
