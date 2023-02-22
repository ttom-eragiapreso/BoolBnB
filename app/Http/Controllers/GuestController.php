<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Feature;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Type_of_stay;
use App\Models\User;
use Illuminate\Support\Facades\Route;


class GuestController extends Controller
{
    public function index(){
        $types_of_stay = Type_of_stay::all();
        $apartments = Apartment::with('images')->where('is_visible', 1)->get();

        return Inertia::render('Guest/Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'types_of_stay' => $types_of_stay,
            'apartments' => $apartments
            ]);
    }

    public function advancedSearch(String $lat = null, String $lng = null){

        $apartments = Apartment::with('images', 'features')->get();

        $features = Feature::all();

        $types_of_stay = Type_of_stay::all();

        return Inertia::render('Guest/AdvancedSearch', compact('apartments', 'types_of_stay', 'features', 'lat', 'lng'));
    }

    public function details(String $slug){

        $apartment = Apartment::where('slug', $slug)->with('images')->first();
        $user = $apartment->user;
        $name = $apartment->user->name;
        $date = $apartment->user->created_at;
        $email = $apartment->user->email;
        $features = Feature::all();


        return Inertia::render('Guest/Details', compact('apartment', 'user', 'features', 'name', 'date', 'email'));

        if($apartment->is_visible) {
            return Inertia::render('Guest/Details', compact('apartment'));
        }else {
            return redirect(route('home'))->with('message', 'Invalid URL');
        }


    }
}
