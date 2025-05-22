<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::truncate();
        $state_list = [
            'Bakau',
            'Banjul Central',
            'Banjul North',
            'Banjul South',
            'Basse',
            'Brikama North',
            'Brikama South',
            'Bundungka Kunda',
            'Busumbala',
            'Central Baddibou',
            'Foni Berefet',
            'Foni Bintang Karanai',
            'Foni Bondali',
            'Foni Jarrol',
            'Foni Kansala',
            'Illiassa',
            'Janjanbureh',
            'Jarra Central',
            'Jarra East',
            'Jarra West',
            'Jeshwang',
            'Jimara',
            'Jokadu',
            'Kantora',
            'Kiang Central',
            'Kiang East',
            'Kiang West',
            'Kombo East',
            'Kombo South',
            'Latrikunda',
            'Lower Baddibou',
            'Lower Fulladu West',
            'Lower Nuimi',
            'Lower Saloum',
            'Niamina Dankunku',
            'Niamina East',
            'Niamina West',
            'Niani',
            'Nianija',
            'Old Yundum',
            'Sabach Sanjal',
            'Sami',
            'Sandu',
            'Sanneh Mentereng',
            'Serrekunda',
            'Serrekunda west',
            'Tallinding Kunjang',
            'Tumana',
            'Upper Fulladu West',
            'Upper Nuimi',
            'Upper Saloum',
            'Wuli East',
            'Wuli West',
        ];

        foreach($state_list as $state){
            State::create([
                'name' => $state,
                'country_id' => 0
            ]);
        }
    }
}
