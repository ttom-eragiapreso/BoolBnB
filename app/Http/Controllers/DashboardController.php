<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Message;
use App\Models\Sponsorship;
use App\Models\Type_of_stay;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){

        $user = auth()->user();

        if($user->email == 'admin@admin.com'){

            $num_apartments = Apartment::count();
            $num_active_apartments = Apartment::where('is_visible', true)->count();
            $num_messages = Message::count();
            $num_messages_today = Message::whereDate('created_at', '=', date('Y-m-d'))->count();
            $user_apartments_id = Apartment::select('id', 'slug')->get()->toArray();

        } else {

            $user_apartments_id = Apartment::select('id')->where('user_id', $user->id)->get();

            $num_apartments = Apartment::where('user_id', $user->id)->count();

            $num_active_apartments = Apartment::where('user_id', $user->id)->where('is_visible', true)->count();

            $num_messages = Message::whereIn('apartment_id', $user_apartments_id)->count();

            $num_messages_today = Message::whereIn('apartment_id', $user_apartments_id)->whereDate('created_at', '=', date('Y-m-d'))->count();

            $user_apartments_id = Apartment::select('id', 'slug')->where('user_id', $user->id)->get()->toArray();
        }

        // logica num messages
        foreach ($user_apartments_id as $apartm) {

            $data_messages[$apartm['slug']] = Message::select(DB::raw('count(*) as total'))->where('apartment_id', $apartm['id'])->groupBy('apartment_id')->get()->toArray();

            $data_views[$apartm['slug']] = View::select(DB::raw('count(*) as total'))->where('apartment_id', $apartm['id'])->groupBy('apartment_id')->get()->toArray();
        }

        // logica num apartments

        // $data = [];

        // foreach ($user_apartments_id as $apartm) {
        //     $data[$apartm['slug']] = View::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))->where('apartment_id', $apartm['id'])->groupBy('date')->get()->toArray();
        // }

        return Inertia::render('Dashboard/Home', compact('num_apartments', 'num_messages', 'num_active_apartments', 'num_messages_today', 'data_views', 'data_messages'));
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
