<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ThreadSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

    	// THREADS
        DB::table('threads')->insert([
            'id' => 29081996,
            'created_at' => Carbon::now()->sub('1 day 12 hours 5 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 12 hours 5 minutes'),
        	'community_id' => 11071967,
            'user_id' => 24111997,
            'title' => 'Bienvenidos a Forohub',
            'body' => '<div class="picture"><img src="https://res.cloudinary.com/dt4uoou5x/image/upload/v1622982802/f63q1gyxalgsljkhq97d.webp"></div><marquee behavior="scroll" direction="left" scrollamount="10" onmouseover="stop()" onmouseleave="start()">Bienvenidos a tod@s!!! Disfrutad de vuestra estancia 😁😁😁</marquee>',
        ]);
    }
}
