<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('utilisateur')->insert([
            'user_type' => 'admin',
            'name' => 'FOLLY James',
            'email' => 'follyjames70@gmail.com',
            'password' => Hash::make('12345678'),
            'date_naiss' => '2008-12-04',
            'telephone' => '97570957',
        ]);
    }
}
