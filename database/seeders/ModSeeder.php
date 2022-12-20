<?php

namespace Database\Seeders;

use App\Models\Mod;
use Illuminate\Database\Seeder;

class ModSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mod::factory()->count(30)->create();
    }
}
