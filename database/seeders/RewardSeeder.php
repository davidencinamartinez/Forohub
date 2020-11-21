<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RewardSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // REWARD
        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        	'name' => 'Iniciado',
            'text' => 'Has verificado tu cuenta',
            'filename' => '9qblXxCxxfDTLqCpvFHYbpSg6fAQwzuI.webp'
        ]);
        DB::table('rewards')->insert([
        	'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        	'name' => '¡Buen viaje!',
            'text' => 'Has respondido a tu primer tema',
            'filename' => 'yI45Mob9fAgZqQLlwz7GWRUdWunDGyeR.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Paso a paso',
            'text' => 'Has respondido a 100 temas',
            'filename' => '5DoD1bAlTu92R2rh0qMRDbYZePX1nzE.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Voy a tope!',
            'text' => 'Has respondido a 500 temas',
            'filename' => 'UyEBv318rlgW5vGu3TCmgV0a7bkTYPb.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Gas Gas Gas',
            'text' => 'Has respondido a 1.000 temas',
            'filename' => 'mZjRxZrLQeABFOnBmpir1o4okDR4wjX.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Sayonara, Baby',
            'text' => 'Has respondido a 10.000 temas',
            'filename' => 'YkeTZgL3Cm7UPm3yW3DOIyKFExgvg4b.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Interstellar',
            'text' => 'Has respondido a 100.000 temas',
            'filename' => 'khGba7hqwuEo8QtzjGO05Oz7wU2UW1Y.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'La unión hace la fuerza',
            'text' => 'Has creado una comunidad',
            'filename' => 'QdN7MwOEFEFiIJ0mM0f1r7EMo9CsG42.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Testigos del éxito',
            'text' => 'Tu comunidad está en el Top del mes',
            'filename' => 'Eujy6wJ61GdtGAtgdlcJPuUctxcHlDI.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Me gusta',
            'text' => 'Has recibido tu primer voto positivo',
            'filename' => 'kKgjRhDTvXwx42F7BUa0HFLpxrZ3Ueu.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Fuera de serie',
            'text' => 'Sé el usuario Top del mes',
            'filename' => 'N0cTuLBlBwe5eFB81uDqt5hXvt3rlzv.webp'
        ]);
        

        // REWARD USERS
        DB::table('users_rewards')->insert([
            'created_at' => Carbon::now()->sub('2 days'),
            'updated_at' => Carbon::now()->sub('2 days'),
        	'user_id' => 24111997,
            'reward_id' => 1
        ]);
        DB::table('users_rewards')->insert([
            'created_at' => Carbon::now()->sub('11 hours 10 minutes'),
            'updated_at' => Carbon::now()->sub('11 hours 10 minutes'),
            'user_id' => 24111998,
            'reward_id' => 1
        ]);
        DB::table('users_rewards')->insert([
            'created_at' => Carbon::now()->sub('1 day 2 hours 40 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 2 hours 40 minutes'),
            'user_id' => 24111999,
            'reward_id' => 1
        ]);
        DB::table('users_rewards')->insert([
            'created_at' => Carbon::now()->sub('1 day 2 hours 20 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 2 hours 20 minutes'),
            'user_id' => 24112000,
            'reward_id' => 1
        ]);
        DB::table('users_rewards')->insert([
            'created_at' => Carbon::now()->sub('11 hours 40 minutes'),
            'updated_at' => Carbon::now()->sub('11 hours 40 minutes'),
            'user_id' => 24112001,
            'reward_id' => 1
        ]);
    }
}
