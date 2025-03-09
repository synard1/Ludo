<?php

namespace Modules\ITAM\Database\Seeders;

use Illuminate\Database\Seeder;

class ITAMDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AssetCategoryAndTypeSeeder::class,
        ]);
    }
}
