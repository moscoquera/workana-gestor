<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(RolsSeeder::class);
        $this->call(AdminsSeeder::class);
        $this->call(citiesAndDeps::class);
        $this->call(countrySeeder::class);
        $this->call(LanguagesSeeder::class);
        $this->call(CompaniesSectorsSeeder::class);
    }
}
