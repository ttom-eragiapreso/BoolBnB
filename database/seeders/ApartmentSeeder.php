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
        for($i = 0; $i < 100; $i++){

            $new_apartment = new Apartment();

            $new_apartment->title = $faker->sentence();
            $new_apartment->slug = generateSlug($new_apartment->title);
            $new_apartment->rooms = $faker->randomDigit();
            $new_apartment->beds = $faker->randomDigit();
            $new_apartment->bathrooms = $faker->randomDigit();
            $new_apartment->square_meters = $faker->randomDigit();
            $new_apartment->city = $faker->city();
            $new_apartment->country = $faker->country();
            $new_apartment->full_address = $faker->streetAddress();
            $new_apartment->latitude = $faker->latitude();
            $new_apartment->longitude = $faker->longitude();
            $new_apartment->price = $faker->randomFloat(2, 0, 99999);
            $new_apartment->cover_image = 'https://loremflickr.com/640/480/house';
            $new_apartment->description = $faker->paragraph(10);
            $new_apartment->user_id = 1;
            $new_apartment->type_of_stay_id = $faker->randomDigitNot(0);
            $new_apartment->save();




        }
    }
}
