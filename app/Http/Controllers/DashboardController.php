<?php

namespace App\Http\Controllers;

use App\Models\Type_of_stay;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){

        $types_of_stay = Type_of_stay::all();

        return Inertia::render('Dashboard/Home', compact('types_of_stay'));
    }
}
