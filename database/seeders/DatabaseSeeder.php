<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // User::factory(10)->create();

        // User::factory(2)->create([
        //     'role' => 'teacher'
        // ]);

        Group::factory(5)->create();

        Registration::factory(10)->create([
            'group_id' => 1
        ]);

        Registration::factory(10)->create([
            'group_id' => random_int(1, 5)
        ]);
    }
}
