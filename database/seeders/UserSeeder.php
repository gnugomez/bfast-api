<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => 'Jordi',
                'surname' => 'Gómez',
                'email' => 'gnugomez' . $i . '@gmail.com',
                'password' => 'Socmanel123!',
            ]);
        }
    }
}
