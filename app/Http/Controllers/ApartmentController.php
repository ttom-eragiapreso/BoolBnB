<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

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

        $validated_request = $request->validate([
            'title'=>'required|max:100|min:3',
            'rooms'=>'required|numeric|max:50',
            'beds'=>'required|numeric|max:50',
            'bathrooms'=>'required|numeric|max:50',
            'square_meters'=>'required|numeric|max:30000',
            'city'=>'required|max:50|min:3',
            'country'=>'required|max:50|min:3',
            'full_address'=>'required|max:100|min:3',
            'price'=>'required|decimal:2',
            'cover_image'=>'required|image|max:5000',
            'description'=>'required|min:10',
        ]);

        $gallery = request('gallery');

        $validated_request['slug'] = generateSlug($validated_request['title']);

        $url = 'https://api.tomtom.com/search/2/geocode/';
        $key = 'LyiQawx4xo4FpPG8VKyj3yHadh1WEDRM';

        $response = json_decode(file_get_contents($url . str_replace(' ', '+', $validated_request['full_address']) . '+' .  str_replace(' ', '+', $validated_request['city']) . '+' .  str_replace(' ', '+', $validated_request['country']) . '.json?key=' . $key), true);

        if(!empty($response['results'])){
            $validated_request['latitude'] = $response['results'][0]['position']['lat'];
            $validated_request['longitude'] = $response['results'][0]['position']['lon'];
        } else {
            $validated_request['latitude'] = null;
            $validated_request['longitude'] = null;
        }

        $validated_request['cover_image'] = $validated_request['cover_image']->store('uploads', 'public');

        $validated_request['user_id'] = auth()->user()->id;

        $validated_request['type_of_stay_id'] = 1;

        $new_apartment = Apartment::create($validated_request);

        if(!empty($gallery)){
               foreach($gallery as $image){
            $new_image = new Image();

            $new_image->url = $image->store('uploads', 'public');
            $new_image->apartment_id = $new_apartment->id;

            $new_image->save();
        }
        }


        return to_route('dashboard.apartment.show', $new_apartment->slug);
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
        $apartment = Apartment::with('images')->where('slug', $slug)->first();

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
    public function edit(String $slug)
    {
        $user = auth()->user();
        $apartment = Apartment::with('images')->where('slug', $slug)->first();

        if($apartment->user_id == $user->id){
            return Inertia::render('Dashboard/Apartment/Edit', compact('apartment'));
        } else {
            return to_route('dashboard.home');
        }
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
        $validated_request = $request->validate([
            'title'=>'required|max:100|min:3',
            'rooms'=>'required|numeric',
            'beds'=>'required|numeric',
            'bathrooms'=>'required|numeric',
            'square_meters'=>'required|numeric',
            'city'=>'required|max:50|min:3',
            'country'=>'required|max:50|min:3',
            'full_address'=>'required|max:100|min:3',
            'price'=>'required|decimal:2',
            'cover_image'=>'nullable|image|max:5000',
            'description'=>'required|min:10',
        ]);

        if(isset($validated_request['cover_image'])){
            Storage::disk('public')->delete($apartment->cover_image);
            $validated_request['cover_image'] = $validated_request['cover_image']->store('uploads', 'public');
        }else {
            $validated_request['cover_image'] = $apartment->cover_image;
        }

        $apartment->update($validated_request);

        return to_route('dashboard.apartment.show', $apartment->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        Storage::disk('public')->delete($apartment->cover_image);

        $apartment->delete();

        return to_route('dashboard.apartment.index')->with('deleted', 'Cancellato');

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
