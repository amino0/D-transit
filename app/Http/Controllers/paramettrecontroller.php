<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class paramettrecontroller extends Controller
{
    public function allfournisseur()
    {
        $fournisseurs  =  DB::select('SELECT * FROM `founisseurs` WHERE  `deleted_at` is null ');
        return view('paramettre.allfournisseur', compact('fournisseurs'));
    }
    public function newfournisseur(Request $request)
    {
        $nom_fourni = request('nom_fourni');
        $tel_fourni = request('tel_fourni');
        $adresse_fourni = request('adresse_fourni');
        $date = now();
        DB::table('founisseurs')->insert([
            'nom_fournisseurs' => $nom_fourni,
            'telephone' => $tel_fourni,
            'created_at' => $date,
            'addresse' => $adresse_fourni
        ]);
        return redirect('/paramettre/fournisseur');
    }
    public function allfamille()
    {
        $familles  =  DB::select('SELECT * FROM `famille_articles` WHERE  `deleted_at` is null ');
        return view('paramettre.allfamille', compact('familles'));
    }
    public function newfamille(Request $request)
    {
        $nom_fourni = request('nom_fourni');
        $date = now();
        DB::table('famille_articles')->insert([
            'nom_famille' => $nom_fourni,
            'created_at' => $date,
        ]);
        return redirect('/paramettre/famille');
    }
    public function allarticle()
    {
        $allarticle  =  DB::select('SELECT * FROM `famille_articles` WHERE  `deleted_at` is null ');
        return view('paramettre.allarticle', compact('allarticle'));
    }
}
