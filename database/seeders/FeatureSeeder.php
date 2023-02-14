<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            'wi-fi',
            'tv',
            'pool',
            'gym',
            'private parking',
            'fire alarm',
            'bbq grill',
            'washer',
            'smoking permitted',
            'air conditioning',
            'oven',
            'heating',
            'refrigerator',
            'freezer',
            'carbon monoxide alarm',
            'hot tub'
        ];

        foreach($features as $feature){
            $new_feauture = new Feature();

            $new_feauture->name = $feature;

            $new_feauture->save();
        }
    }
}
