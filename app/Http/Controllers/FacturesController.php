<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturesController extends Controller
{
    public function index()
    {
        // $dossier = Dossier::all();
        $dossier =  DB::select('SELECT * FROM `dossiers` WHERE `deleted_at` is null ');

        return view('facture.alldosier', compact('dossier'));
    }
    public function FacturesController($id)
    {
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
        $ligne =  DB::select("SELECT *
         FROM `lignes_facturations`
         LEFT JOIN dossiers ON dossiers.id = lignes_facturations.id_dossier
         ORDER BY lignes_facturations.id_dossier");

        return view('facture.single', compact('dossier', 'client', 'debours', 'ligne'));
    }
}
