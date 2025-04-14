<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KarierController extends Controller
{
    public function index()
    {
        return view('karier.index');
    }
}
