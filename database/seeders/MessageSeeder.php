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
        for($i = 0; $i < 100; $i++){
            $new_message = new Message();

            $new_message->email = $faker->email();
            $new_message->name = $faker->name();
            $new_message->content = $faker->paragraphs(3, true);

            $new_message->apartment_id = Apartment::inRandomOrder()->first()->id;

            $new_message->save();
        }
    }
}
