<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class stockcontroller extends Controller
{
    public function index()
    {
        $marchandises =  DB::select("SELECT famille_articles.`nom_famille`,`marchandises`.id_famille,SUM(cubage) as sumcubage FROM `marchandises`,`famille_articles` where `marchandises`.`id_famille` = famille_articles.id group by famille_articles.`nom_famille`;");

        return view('stock.index', compact('marchandises'));
    }
    public function type($id)
    {
        $type =  DB::select("SELECT `marchandises`.`intituler`,SUM(cubage) as sumcubage,`marchandises`.`id_type`  FROM `marchandises` where `marchandises`.`id_famille` = $id group by `marchandises`.`id_type` ");
        return view('stock.type', compact('type'));
    }
    public function famille($id)
    {
        $stock =  DB::select("SELECT  `marchandises`.`intituler`,`marchandises`.`waybill_cubage`,`marchandises`.`cubage`,`commandes`.`nom_fourniseur`,`marchandises`.`prix_unitaire`,`marchandises`.`id_commande`,`marchandises`.`status`,`marchandises`.`created_at`  FROM `marchandises`,commandes where `marchandises`.`id_type` = $id and `marchandises`.id_commande = commandes.id  ");

        return view('stock.familly', compact('stock'));
    }
}
