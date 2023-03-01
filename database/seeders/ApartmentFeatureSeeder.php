<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $apart_feature = config('apartment_feature.apartment_feature');

        foreach ($apart_feature as $elem) {
            $apartment = Apartment::find($elem['apartment_id']);
            $apartment->features()->attach($elem['feature_id']);
        }

    }
}
