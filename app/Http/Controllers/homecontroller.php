<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class homecontroller extends Controller
{
    public function homepage()
    {
        return view('welcome');
    }
    public function devis()
    {
        $devis =  DB::select('SELECT * FROM `devis` WHERE `deleted_at` is null ');

        return view('devis', compact('devis'));
    }
    public function newdevis()
    {

        return view('newdevis');
    }
    public function adddevis(Request $request)
    {
        $nom = request('nom');
        $prix = request('prix');
        $agent = 'Adminstrateur';
        $date = now();

        DB::table('devis')->insert([
            'nom_fournisseur' => $nom,
            'prix' => $prix,
            'created_at' => $date,
            'agent' => $agent,
            'status' => 1,
            'id_fournisseur' => '1'
        ]);

        return redirect('/devis');
    }
    public function add_article_devis($id)
    {

        $panier =  DB::select("SELECT * FROM `paniers` WHERE `paniers`.`id_devis`= $id and `deleted_at` is null ");
        $devis =  DB::select("SELECT * FROM `devis` WHERE id = $id and `deleted_at` is null ");

        return view('add_article_devis', compact('panier', 'devis'));
    }
    // ajouter un article 
    public function addarticle()
    {
        $intituler = request('intituler');
        $quantite = request('quantite');
        $id = request('iddevis');
        $date = now();

        DB::table('paniers')->insert([
            'intituler' => $intituler,
            'quantite' => $quantite,
            'created_at' => $date,
            'status' => 1,
            'id_devis' => $id,
        ]);

        return redirect("/devis/$id");
    }
    // supprimer un article
    public function deletearticle(Request $request)
    {
        $id = request('iddevis2');
        $dare = now();
        DB::table('paniers')
            ->where('id', $id)
            ->update(['deleted_at' => $dare]);


        return redirect("/devis/$id");
    }
    // confirmer les choix des articles
    public function panierenv()
    {
        $id = request('idevis');
        DB::table('devis')
            ->where('id', $id)
            ->update(['status' => '2']);
        return redirect("/devis");
    }
}
