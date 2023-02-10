<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class HousesController extends Controller
{
    public function index(){
        $message = "ciao houses";

        return Inertia::render('Houses', compact('message'));
    }

    public function prova(Request $request){
        dd($request->all());
    }
}
