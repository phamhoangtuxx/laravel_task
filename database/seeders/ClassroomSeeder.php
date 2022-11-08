<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\ClassRoom;
use Carbon\Factory;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ClassRoom::factory()
            ->count(10)
            ->create();
    }
}
