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
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        for ($i = 0; $i < 20; $i++) {
            DB::table('users')->insert([
                'name' => $f->format($i),
                'surname' => sprintf("%02d", $i),
                'email' => 'test' . $i . '@test.com',
                'password' => password_hash('1', PASSWORD_DEFAULT),
            ]);
        }
    }
}
