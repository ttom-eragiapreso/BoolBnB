<?php

namespace Database\Seeders;

use App\Models\Type_of_stay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeOfStaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types =   [  [
            "name" => 'Apartment',
            "icon" => 'fa-regular fa-building',
        ],
        [
            "name" => 'Entire Place',
            "icon" => 'fa-sol fa-house-chimney',
        ],
        [
            "name" => 'Beachfront',
            "icon" => 'fa-solid fa-umbrella-beach',
        ],
        [
            "name" => 'Igloo',
            "icon" => 'fa-solid fa-igloo',
        ],
        [
            "name" => 'Camping',
            "icon" => 'fa-solid fa-tents',
        ],
        [
            "name" => 'Treehouse',
            "icon" => 'fa-solid fa-tree',
        ],
        [
            "name" => 'Arctic',
            "icon" => 'fa-regular fa-snowflake',
        ],
        [
            "name" => 'Ski-in/out',
            "icon" => 'fa-solid fa-person-skiing',
        ],
        [
            "name" => 'Trending',
            "icon" => 'fa-solid fa-fire',
        ],
        [
            "name" => 'Boats',
            "icon" => 'fa-solid fa-sailboat',
        ],
        [
            "name" => 'Hotel',
            "icon" => 'fa-solid fa-hotel',
        ],
        [
            "name" => 'Spa',
            "icon" => 'fa-solid fa-spa',
        ],
        [
            "name" => 'Amazing Views',
            "icon" => 'fa-solid fa-mountain-sun',
        ],
        [
            "name" => 'Private rooms',
            "icon" => 'fa-solid fa-bed',
        ],
        [
            "name" => 'Bed & breakfasts',
            "icon" => 'fa-solid fa-mug-hot',
        ],
        [
            "name" => 'Castles',
            "icon" => 'fa-solid fa-chess-rook',
        ],
        [
            "name" => 'Creative Spaces',
            "icon" => 'fa-solid fa-palette',
        ],
        [
            "name" => 'Vineyards',
            "icon" => 'fa-solid fa-wine-glass',
        ],
        [
            "name" => 'Amazing Pools',
            "icon" => 'fa-solid fa-water-ladder',
        ]];

        foreach($types as $type){
            Type_of_stay::create($type);
        }
    }
}
