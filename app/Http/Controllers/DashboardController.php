<?php

namespace App\Http\Controllers;

use App\Models\Type_of_stay;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){

        return Inertia::render('Dashboard/Home');
    }

}
