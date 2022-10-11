<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class stockcontroller extends Controller
{
    public function index()
    {
        return view('stock.index');
    }
}
