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
            'created_at' => Carbon::now()->sub('2 days'),
            'updated_at' => Carbon::now()->sub('2 days'),
        	'name' => 'Morfeo',
            'email' => 'davidencina1996@gmail.com',
            'password' => Hash::make('Supermarche666!'),
            'about' => 'Amo y Señor del Foro',
            'avatar' => 'rAB7gUyCPXzlEe9MM4zdUrKFzpn8WKm.webp'
        ]);
        DB::table('users')->insert([
            'created_at' => Carbon::now()->sub('1 day 6 hours'),
            'updated_at' => Carbon::now()->sub('1 day 6 hours'),            
            'name' => 'necannut',
            'email' => 'neka541@gmail.com',
            'password' => Hash::make('P@ssw0rd'),
        ]);
        DB::table('users')->insert([
            'created_at' => Carbon::now()->sub('1 day 4 hours 30 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 4 hours 30 minutes'),
            'name' => 'Fizkinfind',
            'email' => 'gabri_24r@hotmail.com',
            'password' => Hash::make('P@ssw0rd'),
        ]);
        DB::table('users')->insert([
            'created_at' => Carbon::now()->sub('1 day 3 hours 10 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 3 hours 10 minutes'),
            'name' => 'kyanitelastrada91',
            'email' => 'carrepputo-5989@yopmail.com',
            'password' => Hash::make('P@ssw0rd'),
        ]);
        DB::table('users')->insert([
            'created_at' => Carbon::now()->sub('16 hours'),
            'updated_at' => Carbon::now()->sub('16 hours'),
            'name' => 'Deerweb',
            'email' => 'jappyladdi@gmail.com',
            'password' => Hash::make('P@ssw0rd'),
        ]);
    }
}
