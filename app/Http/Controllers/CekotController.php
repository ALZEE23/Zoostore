<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CekotController extends Controller
{
     public function index()
    {
        return view('cekot.index'); 
    }
}
