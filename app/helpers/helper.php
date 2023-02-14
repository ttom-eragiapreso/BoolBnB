<?php

use Illuminate\Support\Str;
use App\Models\Apartment;


function generateSlug($string){

    $slug = Str::slug($string, '-');
    $original_slug = $slug;
    $c = 1;
    $exists = Apartment::where('slug',$slug)->first();
    while($exists){
        $slug = $original_slug . '-' . $c;
        $exists = Apartment::where('slug',$slug)->first();
        $c++;
    }
    return $slug;
}
