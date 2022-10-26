<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use PDF;
use App\Document;
use App\Debourd;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class homecontroller extends Controller
{
    public function homepage()
    {
        $cotationtotal  =  DB::select('SELECT count(id) as cntdevis FROM `devis` WHERE  `deleted_at` is null ');
        $cotationqttend  =  DB::select('SELECT count(id) as cntdevis FROM `devis` WHERE `status` = 1  and `deleted_at` is null ');
        $cotationsoumis  =  DB::select('SELECT count(id) as cntdevis FROM `devis` WHERE   `status` = 2  and  `deleted_at` is null ');
        $cotationtraiter  =  DB::select('SELECT count(id) as cntdevis FROM `devis` WHERE  `status` = 3  and  `deleted_at` is null ');
        $cotationcloturer  =  DB::select('SELECT count(id) as cntdevis FROM `devis` WHERE  `status` = 4  and  `deleted_at` is null ');
        $commande  =  DB::select('SELECT count(id) as cntdevis FROM `commandes` WHERE  `deleted_at` is null ');
        $marchandises  =  DB::select('SELECT count(id) as cntdevis FROM `marchandises` WHERE  `deleted_at` is null ');
        return view('welcome', compact('cotationtotal', 'cotationqttend', 'cotationsoumis', 'cotationtraiter', 'cotationcloturer', 'commande', 'marchandises'));
    }
    public function devis()
    {
        $devis =  DB::select('SELECT * FROM `devis` WHERE `deleted_at` is null ');

        return view('devis', compact('devis'));
    }
    public function newdevis()
    {
        $fournisseurs  =  DB::select('SELECT * FROM `founisseurs` WHERE  `deleted_at` is null ');

        return view('newdevis', compact('fournisseurs'));
    }
    public function adddevis(Request $request)
    {
        $id = request('nom');
        $fournisseurs  =  DB::select("SELECT * FROM `founisseurs` WHERE id = $id and `deleted_at` is null ");
        foreach ($fournisseurs as $row) {
            $nom = $row->nom_fournisseurs;
        }
        $prix = request('prix');
        $agent = 'Adminstrateur';
        $date = now();

        DB::table('devis')->insert([
            'nom_fournisseur' => $nom,
            'prix' => $prix,
            'created_at' => $date,
            'agent' => $agent,
            'status' => 1,
            'id_fournisseur' => $id
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
        $famille =  DB::select("SELECT * FROM `famille_articles` ");
        $type_articles =  DB::select("SELECT * FROM `type_articles`");

        return view('add_article_devis', compact('panier', 'devis', 'famille', 'type_articles'));
    }
    // ajouter un article 
    public function addarticle()
    {
        $intituler = request('intituler');
        $tot  =  DB::select("SELECT * FROM `type_articles` where id=$intituler ");
        foreach ($tot as $rodd) {
            $id_famille = $rodd->id_famille;
            $ds_type_article = $rodd->ds_type_article;
        }

        $quantite = request('quantite');
        $metrecube = request('metrecube');
        $description = request('description');
        $prix = request('prix');
        $id = request('iddevis');
        $date = now();

        DB::table('paniers')->insert([
            'intituler' => $ds_type_article,
            'quantite' => $quantite,
            'metrecube' => $metrecube,
            'id_famille' => $id_famille,
            'description' => $description,
            'prix_souhaite' => $prix,
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
        $idarticle = request('idarticle');
        $dare = now();
        DB::table('paniers')
            ->where('id', $idarticle)
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
        $bl = request('bl');
        $client = request('client');
        $prix = request('prix');
        $datebl = request('datee');
        $idevis = request('idevis');

        $date = now();
        $id_last = DB::table('commandes')->insertGetId([
            'nom_fourniseur' => $nom_f,
            'bl' => $bl,
            'nom_client' => $client,
            'prix_convenu' => $prix,
            'date_bl' => $datebl,
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
                'cubage' => $row->metrecube,
                'prix_unitaire' => $row->prix_souhaite,
                'description' => $row->description,
                'id_famille' => $row->id_famille,
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
        return redirect('/commandes');
    }

    public function commandes()
    {
        //  $commade =  DB::select("SELECT SUM( `quatite`*`prix_unitaire`) as sumtotal, `commandes`.`id` , `commandes`.`id_devis`,`commandes`.`nom_fourniseur`,`commandes`.`status`,`commandes`.`created_at` FROM `marchandises`,`commandes` WHERE `commandes`.`id` = `marchandises`.`id_commande` GROUP BY `commandes`.`id` and `commandes`.`id_devis`and  `commandes`.`nom_fourniseur` and `commandes`.`status` and `commandes`.`created_at` ");
        $commade =  DB::select("SELECT * FROM `commandes`  GROUP BY  `commandes`.`id_devis` ");

        return view('commandes', compact('commade'));
    }
    public function commande($id)
    {
        $commande =  DB::select("SELECT * FROM `commandes` WHERE `commandes`.`id`= $id and `deleted_at` is null ");
        foreach ($commande as $row) {
            $iddevis = $row->id_devis;
        }
        $devis =  DB::select("SELECT * FROM `devis` WHERE `devis`.`id`= $iddevis and `deleted_at` is null ");
        $sumcommande =  DB::select("SELECT SUM( `cubage`*`prix_unitaire`) as sumtotal, `commandes`.`id` , `commandes`.`id_devis`,`commandes`.`nom_fourniseur`,`commandes`.`status`,`commandes`.`created_at` FROM `marchandises`,`commandes` WHERE `commandes`.`id` = `marchandises`.`id_commande` and `commandes`.`id` = $id  GROUP BY `commandes`.`id` and `commandes`.`id_devis`and  `commandes`.`nom_fourniseur` and `commandes`.`status` and `commandes`.`created_at` ");
        $marchandises =  DB::select("SELECT * FROM `marchandises` WHERE `marchandises`.`id_commande`= $id and `deleted_at` is null  ");
        $paiements =  DB::select("SELECT * FROM `paiements` WHERE `paiements`.`id_commande`= $id and `deleted_at` is null  ");
        $debours =  DB::select("SELECT * FROM `debourds` WHERE `debourds`.`id_commande`= $id and `deleted_at` is null  ");
        $document =  DB::select("SELECT * FROM `documents` WHERE `documents`.`id_commande`= $id and `deleted_at` is null  ");
        $waybills =  DB::select("SELECT * FROM `waybills` WHERE `waybills`.`id_commande` = $id ");
        $summontant_paye =  DB::select("SELECT  SUM( `montant_paye`) as summontant_paye FROM `paiements` WHERE `paiements`.`id_commande`= $id and `deleted_at` is null   ");
        $type_debours =  DB::select("SELECT  * FROM `type_debours` WHERE `deleted_at` is null   ");
        $marchandise =  DB::select("SELECT * FROM `marchandises` WHERE  cubage is not null and `id_commande` = $id ");
        $vehicules =  DB::select("SELECT * FROM `vehicules` WHERE  status is null ");
        $chauffeurs =  DB::select("SELECT * FROM `chauffeurs` WHERE  status is null ");
        $sumdebours =  DB::select("SELECT SUM(`debourds`.`prix`) as `sumprix` FROM `debourds` WHERE `debourds`.`id_commande`= $id and `deleted_at` is null and `status` = 1 ");

        return view('commande', compact('chauffeurs', 'sumdebours', 'commande', 'vehicules', 'devis', 'sumcommande', 'marchandises', 'paiements', 'waybills', 'document', 'debours', 'summontant_paye', 'marchandise', 'type_debours'));
    }
    public function ajoutpaiement(Request $request)
    {
        $idcommande = request('idcommande');
        $montant = request('montant');
        $date = request('date');
        $compte = request('compte');
        $now = now();
        // dd($date);
        DB::table('paiements')->insert([
            'montant_paye' => $montant,
            'date_paiement' => $date,
            'numero_compte' => $compte,
            'id_commande' => $idcommande,
            'created_at' => $now,
        ]);

        return redirect("/commandes/$idcommande");
    }
    public function ajoutdocument(Request $request)
    {
        $idcommande = request('idcommande');
        $ref = request('ref');
        $intituler = request('intituler');
        $type = request('type');

        $request->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);
        $fileModel = new Document;
        if ($request->file()) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->filename = time() . '_' . $request->file->getClientOriginalName();
            $fileModel->intituler = $intituler;
            $fileModel->ref = $ref;
            $fileModel->type = $type;
            $fileModel->id_commande = $idcommande;
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();
            return redirect("/commandes/$idcommande");
        }
        return redirect("/commandes/$idcommande");
    }
    public function ajoutdebours(Request $request)
    {

        $idcommandee = request('idcommande');
        $prix = request('montant');
        $intituler = request('intituler');
        $type_debours = request('type');

        // dd($idcommande);
        if ($request->file()) {
            $request->validate([
                'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
            ]);
            $fileModel = new Debourd;
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->filename = time() . '_' . $request->file->getClientOriginalName();
            $fileModel->intituler = $intituler;
            $fileModel->prix = $prix;
            $fileModel->type_debours = $type_debours;
            $fileModel->id_commande = $idcommandee;
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();
            return redirect("/commandes/$idcommandee");
        }
        $fileModel = new Debourd;
        $fileModel->intituler = $intituler;
        $fileModel->prix = $prix;
        $fileModel->type_debours = $type_debours;
        $fileModel->id_commande = $idcommandee;
        $fileModel->save();
        return redirect("/commandes/$idcommandee");
    }
    public function ajoutwaybill(Request $request)
    {
        $idcommandee = request('idcommande');
        $quantite = request('quantite');
        $metrecube = request('metrecube');
        $idmarchandises = request('idmarchandises');
        $idvehicule = request('idvehicule');
        $idchauffeur = request('idchauffeur');
        $destination = request('destination');
        $now = now();
        DB::table('waybills')->insert([
            'id_marchandise' => $idmarchandises,
            'quantite' => $quantite,
            'destination' => $destination,
            'nom_chauffeur' => $idchauffeur,
            'matricule' => $idvehicule,
            'metrecube' => $metrecube,
            'id_commande' => $idcommandee,
            'created_at' => $now,
        ]);
        $idwaybill =  DB::getPdo()->lastInsertId();


        $vehicules =  DB::select("SELECT * FROM `vehicules` WHERE  id =  $idvehicule ");
        $chauffeurs =  DB::select("SELECT * FROM `chauffeurs` WHERE  id =  $idchauffeur ");
        $marchandises =  DB::select("SELECT * FROM `marchandises` WHERE  id =  $idmarchandises ");
        foreach ($marchandises as $row) {
            $cutot = $row->waybill_cubage;
        }
        $waybills =  DB::select("SELECT * FROM `waybills` WHERE  id =  $idwaybill ");
        $test = $metrecube + $cutot;
        DB::table('marchandises')->where('id_commande', $idcommandee)->update(array(
            'waybill_quantite' => $quantite,
            'waybill_cubage' => $test,
        ));
        $qrcode = base64_encode(QrCode::format('svg')->size(300)
            ->generate("https://dheemangroup.com/show/"));


        $pdf = PDF::loadView(('pdf_waybill'), compact('qrcode', 'vehicules', 'waybills', 'chauffeurs', 'marchandises'));
        return $pdf->download("waybill.pdf");
    }
    public function generate_fiche(Request $request)
    {
        $id = request('idcommande');
        $date = now();
        $paiements =  DB::select("SELECT * FROM `paiements` WHERE `paiements`.`id_commande`= $id and `deleted_at` is null  ");
        $debours =  DB::select("SELECT * FROM `debourds` WHERE `debourds`.`id_commande`= $id and `deleted_at` is null  ");
        $sumdebours =  DB::select("SELECT SUM(`debourds`.`prix`) as `sumprix` FROM `debourds` WHERE `debourds`.`id_commande`= $id and `deleted_at` is null and `status` = 1 ");
        $marchandise =  DB::select("SELECT * FROM `marchandises` WHERE  cubage is not null and `id_commande` = $id ");
        $cubemarchandise =  DB::select("SELECT SUM(`marchandises`.`cubage`) as cubagesum FROM `marchandises` WHERE  cubage is not null and `id_commande` = $id ");
        $waybills =  DB::select("SELECT * FROM `waybills` WHERE `waybills`.`id_commande` = $id ");
        $commande =  DB::select("SELECT * FROM `commandes` WHERE `commandes`.`id`= $id and `deleted_at` is null ");
        $sumcommande =  DB::select("SELECT SUM( `cubage`*`prix_unitaire`) as sumtotal, `commandes`.`id` , `commandes`.`id_devis`,`commandes`.`nom_fourniseur`,`commandes`.`status`,`commandes`.`created_at` FROM `marchandises`,`commandes` WHERE `commandes`.`id` = `marchandises`.`id_commande` and `commandes`.`id` = $id  GROUP BY `commandes`.`id` and `commandes`.`id_devis`and  `commandes`.`nom_fourniseur` and `commandes`.`status` and `commandes`.`created_at` ");
        $summontant_paye =  DB::select("SELECT  SUM( `montant_paye`) as summontant_paye FROM `paiements` WHERE `paiements`.`id_commande`= $id and `deleted_at` is null   ");

        $pdf = PDF::loadView(('pdf_fiche'), compact('paiements', 'cubemarchandise', 'sumdebours', 'summontant_paye', 'sumcommande', 'debours', 'marchandise', 'waybills', 'commande'));
        return $pdf->download("fiche$date.pdf");
    }
    public function confirmerdebours($id)
    {
        $datemodif = now();
        DB::table('debourds')
            ->where('id', $id)
            ->update([
                'status' => 1,
                'updated_at' => $datemodif,
            ]);
        $debourds =  DB::select("SELECT * FROM `debourds` WHERE `debourds`.`id`= $id ");
        foreach ($debourds as $row) {
            $id_commande = $row->id_commande;
        }
        return redirect("/commandes/$id_commande");
    }
    public function supprimerdocuments($id)
    {

        $documents =  DB::select("SELECT * FROM `documents` WHERE `documents`.`id`= $id ");
        foreach ($documents as $row) {
            $id_commande = $row->id_commande;
        }
        DB::table('documents')
            ->where('id', $id)
            ->update([
                'deleted_at' => 1,
            ]);
        return redirect("/commandes/$id_commande");
    }
    public function supprimerdebours($id)
    {
        $debourds =  DB::select("SELECT * FROM `debourds` WHERE `debourds`.`id`= $id ");
        foreach ($debourds as $row) {
            $id_commande = $row->id_commande;
        }
        DB::table('debourds')
            ->where('id', $id)
            ->update([
                'deleted_at' => 1,
            ]);
        return redirect("/commandes/$id_commande");
    }
    public function confirmerdocuments($id)
    {
        $datemodif = now();
        DB::table('documents')
            ->where('id', $id)
            ->update([
                'status' => 1,
                'updated_at' => $datemodif,
            ]);
        $documents =  DB::select("SELECT * FROM `documents` WHERE `documents`.`id`= $id ");
        foreach ($documents as $row) {
            $id_commande = $row->id_commande;
        }
        return redirect("/commandes/$id_commande");
    }
    public function supprimerpaiement($id)
    {
        $debourds =  DB::select("SELECT * FROM `paiements` WHERE `paiements`.`id`= $id ");
        foreach ($debourds as $row) {
            $id_commande = $row->id_commande;
        }
        DB::table('paiements')
            ->where('id', $id)
            ->update([
                'deleted_at' => 1,
            ]);
        return redirect("/commandes/$id_commande");
    }
    public function confirmerpaiement($id)
    {
        $datemodif = now();
        DB::table('paiements')
            ->where('id', $id)
            ->update([
                'status' => 1,
                'updated_at' => $datemodif,
            ]);
        $documents =  DB::select("SELECT * FROM `paiements` WHERE `paiements`.`id`= $id ");
        foreach ($documents as $row) {
            $id_commande = $row->id_commande;
        }
        return redirect("/commandes/$id_commande");
    }
}
