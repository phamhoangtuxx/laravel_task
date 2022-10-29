<?php

namespace Database\Seeders;

use App\Models\ClassRooms;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //tao 20 ong user
        // \App\Models\User::factory(10)->create();
        $this->call([
            ClassRoomSeeder::class,
        ]);
        // DB::table('class_room)->insert([
        //     'name' => Str::random(10),
        //     'icon' => Str::random(10),
        //     'description' => Str::random(10),
        // ]);
        //tao 10 classroom
    }
}
