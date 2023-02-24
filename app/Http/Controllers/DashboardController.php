<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Type_of_stay;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){

        return Inertia::render('Dashboard/Home');
    }

    public function transactions(){

        $user = auth()->user();
        if($user->email == 'admin@admin.com'){
            $user_apartments = Apartment::with('sponsorships')->get();
        } else {
            $user_apartments = Apartment::where('user_id', $user->id)->with('sponsorships')->get();
        }

        return Inertia::render('Dashboard/Transactions', compact('user_apartments'));
    }

}
