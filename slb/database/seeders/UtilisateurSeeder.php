<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('utilisateur')->insert([
            'user_type' => 'admin',
            'name' => 'Admin Principal',
            'email' => 'admin@example.com',
            'date_naiss' => '1990-01-01',
            'telephone' => '+22890000000',
            'password' => Hash::make('12345678'), // mot de passe haché
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
