<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Feature;
use App\Models\Image;
use App\Models\Type_of_stay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $features = Feature::all();
        $type_of_stays = Type_of_stay::all();
        return Inertia::render('Dashboard/Apartment/Create', compact('features','type_of_stays'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gallery = request('gallery');

        $features = request('features');

        $validated_request = $request->validate([
            'title'=>'required|max:100|min:3',
            'rooms'=>'required|numeric|min:0|max:50',
            'beds'=>'required|numeric|min:0|max:50',
            'bathrooms'=>'required|numeric|min:0|max:50',
            'square_meters'=>'required|numeric|min:0|max:60000',
            'city'=>'required|max:50|min:3',
            'country'=>'required|max:50|min:3',
            'full_address'=>'required|max:100|min:3',
            'latitude' => 'required',
            'longitude' => 'required',
            'price'=>'required|decimal:2|min:0|max:90000',
            'cover_image'=>'required|image|max:5000',
            'description'=>'required|min:10',
            'type_of_stay_id'=>'required',
            'is_visible' => 'required'
        ]);

        $validated_request['slug'] = generateSlug($validated_request['title']);

        $validated_request['cover_image'] = $validated_request['cover_image']->store('uploads', 'public');

        $validated_request['user_id'] = auth()->user()->id;

        $new_apartment = Apartment::create($validated_request);

        if(!empty($features)){
            $new_apartment->features()->attach($features);
        }

        if(!empty($gallery)){
            foreach($gallery as $image){
                $new_image = new Image();
                $new_image->url = $image->store('uploads', 'public');
                $new_image->apartment_id = $new_apartment->id;
                $new_image->save();
            }
        }

        return to_route('dashboard.apartment.show', $new_apartment->slug)->with('message', 'Apartment created successfully.');
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
        $apartment = Apartment::with(['images', 'features', 'type_of_stay'])->where('slug', $slug)->first();

        if($user === null || $apartment === null){
            abort(404);
        }


        if($apartment->user_id == $user->id){
            return Inertia::render('Dashboard/Apartment/Show', compact('apartment'));
        } else {
            return to_route('dashboard.home')->with('message', 'Not allowed.');
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
        $apartment = Apartment::with(['images', 'features'])->where('slug', $slug)->first();

        $features = Feature::all();
        $type_of_stays = Type_of_stay::all();

        if($apartment->user_id == $user->id){
            return Inertia::render('Dashboard/Apartment/Edit', compact('apartment', 'features', 'type_of_stays'));
        } else {
            return to_route('dashboard.home')->with('message', 'Not allowed.');
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

        $old_gallery_images = request('oldGallery');
        $new_gallery_images = request('gallery');
        $features = request('features');

        $validated_request = $request->validate([
            'title'=>'required|max:100|min:3',
            'rooms'=>'required|numeric|min:0|max:50',
            'beds'=>'required|numeric|min:0|max:50',
            'bathrooms'=>'required|numeric|min:0|max:50',
            'square_meters'=>'required|numeric|min:0|max:60000',
            'city'=>'required|max:50|min:3',
            'country'=>'required|max:50|min:3',
            'full_address'=>'required|max:100|min:3',
            'latitude' => 'required',
            'longitude' => 'required',
            'price'=>'required|decimal:2|min:0|max:90000',
            'cover_image'=>'nullable|image|max:5000',
            'type_of_stay_id'=>'required',
            'description'=>'required|min:10',
            'is_visible'=>'required'
        ]);

        if(isset($validated_request['cover_image'])){
            Storage::disk('public')->delete($apartment->cover_image);
            $validated_request['cover_image'] = $validated_request['cover_image']->store('uploads', 'public');
        }else {
            $validated_request['cover_image'] = $apartment->cover_image;
        }

        if(!empty($features)){
            $apartment->features()->sync($features);
        } else {
            $apartment->features()->detach();
        }

        // Se ho inserito delle nuove immagini
        if(!empty($new_gallery_images)){
            // Le vado ad aggiungere a quelle gia esistenti
            foreach($new_gallery_images as $image){
                $new_image = new Image();

                $new_image->url = $image->store('uploads', 'public');
                $new_image->apartment_id = $apartment->id;

                $new_image->save();
            }
        }

        // se avevo delle immagini nella galleria
        if(!empty($old_gallery_images)){
            // ciclo tra queste e verifico se ne voglio cancellare qualcuna
            foreach($old_gallery_images as $index => $flag){
                if(!$flag){
                    Storage::disk('public')->delete($apartment->images[$index]->url);
                    $image = Image::find($apartment->images[$index]->id);
                    $image->delete();
                }
            }
        }

        $apartment->update($validated_request);

        return to_route('dashboard.apartment.show', $apartment->slug)->with('message', 'Apartment updated succesfully.');
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

        return redirect()->route('dashboard.apartment.index')->with('message', 'Apartment deleted succesfully.');

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
