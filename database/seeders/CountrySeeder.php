<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();

        $country_list = [
            /*'Austria',
            'Belgium',
            'Canada',
            'Czech Republic',
            'Denmark',
            'Finland',
            'France',
            'Germany',
            'Italy',
            'Luxembourg',
            'Netherlands',
            'Norway',
            'Portugal',
            'Spain',
            'Sweden',
            'Switzerland',
            'Turkey',
            'Ukraine',*/
            'USA',
            'United Kingdom',
            'The Gambia',
        ];

        foreach($country_list as $country){
            Country::create([
                'name' => $country
            ]);
        }
    }
}
