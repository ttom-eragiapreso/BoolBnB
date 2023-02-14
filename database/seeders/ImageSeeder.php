<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i = 0; $i < 100; $i++){
            $new_image = new Image();
            $new_image->url = 'https://loremflickr.com/640/480/house';
            $new_image->apartment_id = Apartment::inRandomOrder()->first()->id;
            $new_image->save();
        }
    }
}
