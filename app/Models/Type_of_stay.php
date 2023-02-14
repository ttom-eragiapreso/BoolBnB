<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_of_stay extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon'
    ];

    public function apartments(){
        return $this->hasMany(Apartment::class);
    }
}
