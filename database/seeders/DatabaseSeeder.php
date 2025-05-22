<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        // $this->call(RegionSeeder::class);
        // $this->call(PollingwardSeeder::class);
        $this->call(ModelPermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ChapterSeeder::class);
        $this->call(EthnicitySeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
