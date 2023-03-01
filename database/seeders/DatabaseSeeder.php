<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Apartment;
use App\Models\Feature;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(
            [
                UserSeeder::class,
                TypeOfStaySeeder::class,
                ApartmentSeeder::class,
                FeatureSeeder::class,
                ApartmentFeatureSeeder::class,
                SponsorshipSeeder::class,
                ApartmentSponsorshipSeeder::class,
                ImageSeeder::class,
                ViewSeeder::class,
                MessageSeeder::class,
            ]
        );
    }
}
