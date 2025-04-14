<?php

namespace Database\Seeders;

use Database\Seeders\tenant\MenuSeeder;
use Database\Seeders\tenant\PermissionSeeder;
use Database\Seeders\tenant\QoptionSeeder;
use Database\Seeders\tenant\tagSeeder;
use Database\Seeders\tenant\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeederTenant extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\Lote::factory(200)->create();
        //\App\Models\Familia::factory(3000)->create();
        //\App\Models\Beneficiario::factory(1000)->create();
        // dd(tenant());
        $this->call([
            // DocumentSeeder::class,
            MenuSeeder::class,
            tagSeeder ::class,
            PermissionSeeder::class,
            QoptionSeeder ::class,
            UserSeeder::class,
            // escolaridadeSeeder::class,
            // // estadocivilSeeder::class,
            // ProfissaoSeeder::class,
        ]);

    }
}
