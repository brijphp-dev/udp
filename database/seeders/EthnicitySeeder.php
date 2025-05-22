<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ethnicity;

class EthnicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ethnicity::truncate();
        $ethnic_lists = [
            'Bainuk',
            'Balanta',
            'Bassari',
            'Blafada',
            'Gambian Americans',
            'Gambian Creole',
            'Jakhanke',
            'Jola',
            'Karoninka',
            'Mandinka',
            'Manjak',
            'Mankanya',
            'Oku',
            'Serer',
            'Soninke',
            'Wolof',
            'Others',
        ];

        foreach($ethnic_lists as $ethnic){
            Ethnicity::create([
                'ename' => $ethnic
            ]);
        }
    }
}
