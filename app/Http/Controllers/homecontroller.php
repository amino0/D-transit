<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use PDF;

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
    // modifier devis 
    public function edit_devis($id)
    {
        $devis =  DB::select("SELECT * FROM `devis` WHERE id = $id and `deleted_at` is null ");
        return view('devis_edit', compact('devis'));
    }
    public function edit_devis_ac(Request $request)
    {
        $id = request('idevis');
        $nom = request('nom_fournisseur');
        $prix = request('prix_souhaitez');
        $datemodif = now();
        DB::table('devis')
            ->where('id', $id)
            ->update([
                'nom_fournisseur' => $nom,
                'prix' => $prix,
                'updated_at' => $datemodif,
            ]);


        return redirect("/devis");
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
    public function deletearticle_ar(Request $request)
    {
        $id = request('iddevis2');
        $id_devis = request('id_devis');

        $dare = now();
        DB::table('paniers')
            ->where('id', $id)
            ->update(['deleted_at' => $dare]);


        return redirect("/devis/arrete/$id_devis");
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
    public function soummetre_devis(Request $request, $id)
    {
        $devis =  DB::select("SELECT * FROM `devis` WHERE id = $id and `deleted_at` is null ");
        $panier =  DB::select("SELECT * FROM `paniers` WHERE `paniers`.`id_devis`= $id and `deleted_at` is null ");

        DB::table('devis')
            ->where('id', $id)
            ->update(['status' => '3']);

        $pdf = PDF::loadView(('devis_pdf'), compact('devis', 'panier'));
        return $pdf->download("devis_$id.pdf");

        // return view('devis_pdf', compact('devis', 'panier'));
    }
    public function arrete($id)
    {

        $devis =  DB::select("SELECT * FROM `devis` WHERE id = $id and `deleted_at` is null ");
        $panier =  DB::select("SELECT * FROM `paniers` WHERE `paniers`.`id_devis`= $id and `deleted_at` is null ");
        return view('pas_cmd_arrete', compact('devis', 'panier'));
    }
    public function addarticle_ar()
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

        return redirect("/devis/arrete/$id");
    }
    public function confirmer_devis(Request $request)
    {
        // creation d'une commande a partir du devis 
        $nom_f = request('nom_fournisseur');
        $prix = request('prix');
        $idevis = request('idevis');
        $date = now();
        $id_last = DB::table('commandes')->insertGetId([
            'nom_fourniseur' => $nom_f,
            'prix_convenu' => $prix,
            'created_at' => $date,
            'status' => '1',
            'id_devis' => $idevis,
        ]);


        $id_devis = request('idevis');
        $panier =  DB::select("SELECT * FROM `paniers` WHERE `paniers`.`id_devis`= $id_devis and `deleted_at` is null ");
        // copie les articles valider dans une table marchandises 
        foreach ($panier as $row) {
            DB::table('marchandises')->insert([
                'intituler' => $row->intituler,
                'quatite' => $row->quantite,
                'created_at' => $date,
                'status' => '1',
                'id_commande' => $id_last,

            ]);
            // modifier le status du devis, desormais travailler sur la commande 
            DB::table('devis')
                ->where('id', $id_devis)
                ->update([
                    'status' => '4',
                ]);
        }
        return ' fini va voir ';
    }

    public function commandes()
    {
        $commade =  DB::select("SELECT * FROM `commandes` WHERE `deleted_at` is null ");
        return view('commandes', compact('commade'));
    }
}
