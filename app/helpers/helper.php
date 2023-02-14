<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

function generateSlug($string, Model $model){

    $slug = Str::slug($string, '-');
    $original_slug = $slug;
    $c = 1;
    $exists = $model::where('slug',$slug)->first();
    while($exists){
        $slug = $original_slug . '-' . $c;
        $exists = $model::where('slug',$slug)->first();
        $c++;
    }
    return $slug;
}
