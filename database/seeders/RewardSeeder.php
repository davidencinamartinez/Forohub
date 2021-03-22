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
            'text' => 'Has acumulado un total de  tu primer tema',
            'filename' => 'yI45Mob9fAgZqQLlwz7GWRUdWunDGyeR.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Paso a paso',
            'text' => 'Has acumulado un total de  100 mensajes',
            'filename' => '5DoD1bAlTu92R2rh0qMRDbYZePX1nzE.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Voy a tope!',
            'text' => 'Has acumulado un total de  500 mensajes',
            'filename' => 'UyEBv318rlgW5vGu3TCmgV0a7bkTYPb.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Gas Gas Gas',
            'text' => 'Has acumulado un total de  1.000 mensajes',
            'filename' => 'mZjRxZrLQeABFOnBmpir1o4okDR4wjX.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Sayonara, Baby',
            'text' => 'Has acumulado un total de  10.000 mensajes',
            'filename' => 'YkeTZgL3Cm7UPm3yW3DOIyKFExgvg4b.webp'
        ]);

        DB::table('rewards')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Interstellar',
            'text' => 'Has acumulado un total de  50.000 mensajes',
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
    }
}
