<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DossierController extends Controller
{
    public function index()
    {

        // $dossier = Dossier::all();
        $dossier =  DB::select('SELECT * FROM `dossiers` WHERE `deleted_at` is null ');

        return view('dossier.alldosier', compact('dossier'));
    }
    public function dossier($id)
    {
        // $dossier = Dossier::all();
        $dossier =  DB::select("SELECT * FROM `dossiers` WHERE `deleted_at` is null and id = $id ");
        //  $debours =  DB::select("SELECT * FROM `clients`,`dossiers` WHERE `dossiers`.`id` = $id  and `clients`.`id` = `dossiers`.`idclient` ");
        $client =  DB::select("SELECT *
        FROM `dossiers`
        LEFT JOIN clients ON clients.id = dossiers.idclient
        ORDER BY clients.id");
        $debours =  DB::select("SELECT *
        FROM `debourds`
        LEFT JOIN dossiers ON dossiers.id = debourds.Id_dossier
        ORDER BY debourds.id");
        $marchandise = DB::select("SELECT *
        FROM `marchandises`,`dossiers`
        WHERE dossiers.id = marchandises.id_dossier and marchandises.id_dossier = $id
        ORDER BY marchandises.id_dossier");
        $contenaires = DB::select("SELECT *
        FROM `contenaires`,`dossiers`
        WHERE dossiers.id = contenaires.id_dossier and contenaires.id_dossier = $id
        ORDER BY contenaires.id_dossier");
        $vehicules = DB::select("SELECT *
        FROM `vehicules`,`dossiers`
        WHERE dossiers.id = vehicules.id_dossier and vehicules.id_dossier = $id
        ORDER BY vehicules.id_dossier");

        return view('dossier.dosier', compact('dossier', 'client', 'debours', 'marchandise', 'contenaires', 'vehicules'));
    }
    public function newdebours(Request $request)
    {
        $request('iddossier');
        $request('iddossier');
    }
    public function newdossierclient($id)
    {
        $client =  DB::select("SELECT * FROM `clients` WHERE id = $id and `deleted_at` is null ");
        $dossier =  DB::select("SELECT * FROM `dossiers` WHERE idclient = $id and `deleted_at` is null ");

        return view('dossier.newdossierclient', compact('client', 'dossier'));
    }
    public function creedossier()
    {
        DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
    }
}
