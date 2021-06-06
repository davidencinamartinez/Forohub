<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

    	// USERS

       	DB::table('users')->insert([
            'id' => 24111997,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        	'name' => 'Morfeo',
            'email' => 'davidencina1996@gmail.com',
            'password' => Hash::make('Supermarche666!'),
            'about' => 'Amo y Señor del Foro',
            'avatar' => 'https://res.cloudinary.com/dt4uoou5x/image/upload/v1622985065/mod_pu7cwk.webp'
        ]);
    }
}
