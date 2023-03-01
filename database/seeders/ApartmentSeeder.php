<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $apartments = config('apartments.apartments');

        foreach ($apartments as $apartment) {

            $new_apartment = new Apartment();

            $new_apartment->title = $apartment['title'];
            $new_apartment->slug = $apartment['slug'];
            $new_apartment->rooms = $apartment['rooms'];
            $new_apartment->beds = $apartment['beds'];
            $new_apartment->bathrooms = $apartment['bathrooms'];
            $new_apartment->square_meters = $apartment['square_meters'];
            $new_apartment->city = $apartment['city'];
            $new_apartment->country = $apartment['country'];
            $new_apartment->full_address = $apartment['full_address'];
            $new_apartment->latitude = $apartment['latitude'];
            $new_apartment->longitude = $apartment['longitude'];
            $new_apartment->price = $apartment['price'];
            $new_apartment->cover_image = $apartment['cover_image'];
            $new_apartment->description = $apartment['description'];
            $new_apartment->is_visible = $apartment['is_visible'];
            $new_apartment->user_id = $apartment['user_id'];
            $new_apartment->created_at = $apartment['created_at'];
            $new_apartment->updated_at = $apartment['updated_at'];
            $new_apartment->type_of_stay_id = $apartment['type_of_stay_id'];

            $new_apartment->save();

        }
    }
}
