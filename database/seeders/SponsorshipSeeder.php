<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = [
            [
                "name" => "base",
                "price" => 2.99,
                "length_hours" => 24
            ],
            [
                "name" => "premium",
                "price" => 5.99,
                "length_hours" => 72
            ],
            [
                "name" => "deluxe",
                "price" => 9.99,
                "length_hours" => 144
            ],
        ];

        foreach($sponsorships as $sponsorship){
            Sponsorship::create($sponsorship);
        }
    }
}
