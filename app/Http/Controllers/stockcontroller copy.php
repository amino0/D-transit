<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class stockcontroller extends Controller
{
    public function index()
    {
        $marchandises =  DB::select("SELECT famille_articles.`nom_famille`,`marchandises`.id_famille,SUM(cubage) as sumcubage FROM `marchandises`,`famille_articles` where `marchandises`.`id_famille` = famille_articles.id group by famille_articles.`nom_famille`;
        ");

        return view('stock.index', compact('marchandises'));
    }
    public function famille($id)
    {
        $stock =  DB::select("SELECT  * FROM `marchandises` where `marchandises`.`id_famille` = $id");

        return view('stock.familly', compact('stock'));
    }
}
