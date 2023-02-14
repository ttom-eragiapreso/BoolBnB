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
            "icon" => 'fa-sol fa-umbrella-beach',
        ],
        [
            "name" => 'Igloo',
            "icon" => 'fa-sol fa-igloo',
        ],
        [
            "name" => 'Camping',
            "icon" => 'fa-sol fa-tents',
        ],
        [
            "name" => 'Treehouse',
            "icon" => 'fa-sol fa-tree',
        ],
        [
            "name" => 'Arctic',
            "icon" => 'fa-regular fa-snowflake',
        ],
        [
            "name" => 'Ski-in/out',
            "icon" => 'fa-sol fa-person-skiing',
        ],
        [
            "name" => 'Trending',
            "icon" => 'fa-sol fa-fire',
        ],
        [
            "name" => 'Boats',
            "icon" => 'fa-sol fa-sailboat',
        ],
        [
            "name" => 'Hotel',
            "icon" => 'fa-sol fa-hotel',
        ],
        [
            "name" => 'Spa',
            "icon" => 'fa-sol fa-spa',
        ],
        [
            "name" => 'Amazing Views',
            "icon" => 'fa-sol fa-mountain-sun',
        ],
        [
            "name" => 'Private rooms',
            "icon" => 'fa-sol fa-bed',
        ],
        [
            "name" => 'Bed & breakfasts',
            "icon" => 'fa-sol fa-mug-hot',
        ],
        [
            "name" => 'Castles',
            "icon" => 'fa-sol fa-chess-rook',
        ],
        [
            "name" => 'Creative Spaces',
            "icon" => 'fa-sol fa-palette',
        ],
        [
            "name" => 'Vineyards',
            "icon" => 'fa-sol fa-wine-glass',
        ],
        [
            "name" => 'Amazing Pools',
            "icon" => 'fa-sol fa-water-ladder',
        ]];

        foreach($types as $type){
            Type_of_stay::create($type);
        }
    }
}
