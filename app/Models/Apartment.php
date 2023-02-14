<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'rooms',
        'beds',
        'bathrooms',
        'square_meters',
        'city',
        'country',
        'full_address',
        'latitude',
        'longitude',
        'price',
        'cover_image',
        'description',
        'is_visible',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function views(){
        return $this->hasMany(View::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function features(){
        return $this->belongsToMany(Feature::class);
    }

    public function sponsorships(){
        return $this->belongsToMany(Sponsorship::class);
    }

    public function type_of_stay(){
        return $this->belongsTo(Type_of_stay::class);
    }
}
