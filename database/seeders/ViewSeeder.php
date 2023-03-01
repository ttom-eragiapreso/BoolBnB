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

        $apartments = Apartment::all()->toArray();

        foreach ($apartments as $apartment) {

            for ($z = random_int(1, 50); $z > 0; $z--) {

                for ($i = 8; $i > 0; $i--) {
                    $new_view = new View();
                    $new_view->ip_address = $faker->ipv4();
                    $new_view->apartment_id = $apartment['id'];
                    $y = $i - 1;
                    $new_view->created_at = $faker->dateTimeBetween(" -$i days", "-$y days");
                    $new_view->save();
                }
            }
        }
    }
}
