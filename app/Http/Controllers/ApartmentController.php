<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $user_apartments = $user->apartments;
        return Inertia::render('Dashboard/Apartment/Index', compact('user_apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Dashboard/Apartment/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(string $slug)
    {
        $user = auth()->user();
        $apartment = Apartment::where('slug', $slug)->first();

        if($apartment->user_id == $user->id){
            return Inertia::render('Dashboard/Apartment/Show', compact('apartment'));
        } else {
            return to_route('dashboard.home');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        return Inertia::render('Dashboard/Apartment/Edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        //
    }

    public function messages(){

        return Inertia::render('Dashboard/Apartment/Messages');
    }

    public function stats(){

        return Inertia::render('Dashboard/Apartment/Stats');
    }

    public function sponsorship(){

        return Inertia::render('Dashboard/Apartment/Sponsorship');
    }
}
