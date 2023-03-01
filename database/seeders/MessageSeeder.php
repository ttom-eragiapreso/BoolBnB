<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class MessageSeeder extends Seeder
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

            for ($i = random_int(1, 20); $i > 0; $i--) {
                $new_message = new Message();
                $new_message->email = $faker->email();
                $new_message->name = $faker->realTextBetween($minNbChars = 5, $maxNbChars = 25, $indexSize = 2);
                $new_message->content = $faker->realTextBetween($minNbChars = 25, $maxNbChars = 254, $indexSize = 2);
                $new_message->created_at = $faker->dateTimeBetween("-4 days", "+1 days");
                $new_message->apartment_id = $apartment['id'];
                $new_message->save();
            }

        }
    }
}
