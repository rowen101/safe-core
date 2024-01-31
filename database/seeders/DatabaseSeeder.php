<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\Admin\AppSeeder;
use Database\Seeders\Admin\BDirectorSeeder;
use Database\Seeders\Admin\ClientSeeder;
use Database\Seeders\Admin\MenuSeeder;
use Database\Seeders\Admin\UserSeeder;
use Database\Seeders\Admin\CommingSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MenuSeeder::class,
            UserSeeder::class,
            AppSeeder::class,
            CommingSeeder::class,
            BDirectorSeeder::class,
            ClientSeeder::class
        ]);


    }
}
