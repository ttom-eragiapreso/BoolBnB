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
        $store = [];
        for ($i=0; $i < 200; $i++) {
            $rnd_apartment = Apartment::inRandomOrder()->first();
            $rnd_feature_id = Feature::inRandomOrder()->first()->id;
            if(!array_search("$rnd_apartment->id-$rnd_feature_id", $store)){
                array_push($store, "$rnd_apartment->id-$rnd_feature_id");
                $rnd_apartment->features()->attach($rnd_feature_id);
            }
        }
    }
}
