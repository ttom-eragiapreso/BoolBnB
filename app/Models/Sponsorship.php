<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApartmentSponsorship;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'length_hours'
    ];

    public function apartments(){
        return $this->belongsToMany(Apartment::class)->withPivot(['start', 'end']);
    }
}
