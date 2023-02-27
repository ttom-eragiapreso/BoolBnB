<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 500; $i++) {
            $new_view = new View();

            $new_view->ip_address = $faker->ipv4();
            $new_view->apartment_id = Apartment::inRandomOrder()->first()->id;


            $new_view->created_at = $faker->dateTimeBetween('-1 week', 'now');

            $new_view->save();
        }
    }
}
