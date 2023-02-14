<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Faker\Generator as Faker;


class ApartmentSponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $store = [];
        for ($i=0; $i < 50; $i++) {
            $rnd_apartment = Apartment::inRandomOrder()->first();
            $rnd_sponsorship_id = Sponsorship::inRandomOrder()->first()->id;
            if(!array_search("$rnd_apartment->id-$rnd_sponsorship_id", $store)){
                array_push($store, "$rnd_apartment->id-$rnd_sponsorship_id");
                $rnd_apartment->sponsorships()->attach($rnd_sponsorship_id, [
                    'start' => $faker->dateTime(),
                    'end' => $faker->dateTime()
                ]);

            }
        }
    }
}
