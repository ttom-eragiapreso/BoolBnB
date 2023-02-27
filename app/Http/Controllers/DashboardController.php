<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Message;
use App\Models\Sponsorship;
use App\Models\Type_of_stay;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){

        $user = auth()->user();

        $user_apartments_id = Apartment::select('id')->where('user_id', $user->id)->get();

        $num_apartments = Apartment::where('user_id', $user->id)->count();

        $num_active_apartments = Apartment::where('user_id', $user->id)->where('is_visible', true)->count();

        $num_messages = Message::whereIn('apartment_id', $user_apartments_id)->count();

        $num_messages_today = Message::whereIn('apartment_id', $user_apartments_id)->whereDate('created_at', '=', date('Y-m-d'))->count();

        return Inertia::render('Dashboard/Home', compact('num_apartments', 'num_messages', 'num_active_apartments', 'num_messages_today'));
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
