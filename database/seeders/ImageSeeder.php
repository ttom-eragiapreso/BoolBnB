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

        $images = config('images.images');

        foreach ($images as $image) {
            $new_image = new Image();
            $new_image->id = $image['id'];
            $new_image->url = $image['url'];
            $new_image->apartment_id = $image['apartment_id'];
            $new_image->created_at = $image['created_at'];
            $new_image->updated_at = $image['updated_at'];
            $new_image->save();
        }

    }
}
