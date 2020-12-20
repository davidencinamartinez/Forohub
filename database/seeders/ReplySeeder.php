<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReplySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // REPLY
        DB::table('replies')->insert([
            'id' => 26052016,
            'created_at' => Carbon::now()->sub('3 hours'),
            'updated_at' => Carbon::now()->sub('3 hours'),
        	'thread_id' => 29081996,
        	'user_id' => 24111998,
            'text' => 'POLE',
        ]);
        DB::table('replies')->insert([
            'created_at' => Carbon::now()->sub('2 hours 20 minutes'),
            'updated_at' => Carbon::now()->sub('2 hours 20 minutes'),
            'thread_id' => 29081996,
            'user_id' => 24112000,
            'text' => 'Saludos!!!',
        ]);
        DB::table('replies')->insert([
            'created_at' => Carbon::now()->sub('2 hours'),
            'updated_at' => Carbon::now()->sub('2 hours'),
            'thread_id' => 29081997,
            'user_id' => 24112001,
            'text' => 'Pintaza! 😋',
        
        ]);
    }
}
