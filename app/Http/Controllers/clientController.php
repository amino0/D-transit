<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class clientController extends Controller
{
    public function index()
    {

        // $dossier = Dossier::all();
        $client =  DB::select('SELECT * FROM `clients` WHERE `deleted_at` is null ');

        return view('client.allclient', compact('client'));
    }
    public function client($id)
    {
        $client =  DB::select("SELECT * FROM `clients` WHERE id = $id and `deleted_at` is null ");
        $dossier =  DB::select("SELECT * FROM `dossiers` WHERE idclient = $id and `deleted_at` is null ");
        return view('client.client', compact('client', 'dossier'));
    }
    public function newclient()
    {
        return view('client.newclient');
    }
}
