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
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            	'name' => 'Iniciado',
                'text' => 'Verifica tu cuenta',
                'filename' => '9qblXxCxxfDTLqCpvFHYbpSg6fAQwzuI.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => '¡Buen viaje!',
                'text' => 'Escribe tu primer mensaje',
                'filename' => 'yI45Mob9fAgZqQLlwz7GWRUdWunDGyeR.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Paso a paso',
                'text' => 'Escribe 100 mensajes',
                'filename' => '5DoD1bAlTu92R2rh0qMRDbYZePX1nzE.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Voy a tope!',
                'text' => 'Escribe 500 mensajes',
                'filename' => 'UyEBv318rlgW5vGu3TCmgV0a7bkTYPb.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Gas Gas Gas',
                'text' => 'Escribe 1.000 mensajes',
                'filename' => 'mZjRxZrLQeABFOnBmpir1o4okDR4wjX.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Sayonara, Baby',
                'text' => 'Escribe 10.000 mensajes',
                'filename' => 'YkeTZgL3Cm7UPm3yW3DOIyKFExgvg4b.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Interstellar',
                'text' => 'Escribe 50.000 mensajes',
                'filename' => 'khGba7hqwuEo8QtzjGO05Oz7wU2UW1Y.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'La unión hace la fuerza',
                'text' => 'Crea una comunidad',
                'filename' => 'QdN7MwOEFEFiIJ0mM0f1r7EMo9CsG42.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Testigos del éxito',
                'text' => 'Consigue que tu comunidad salga en el Top Semanal',
                'filename' => 'Eujy6wJ61GdtGAtgdlcJPuUctxcHlDI.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Aportando mi granito de arena',
                'text' => 'Crea tu primer tema',
                'filename' => 'oNqiz62mQu9J2XzvqxRwyOGFDvsZdNw.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Un pequeño paso para el hombre, un gran salto para la humanidad',
                'text' => 'Consigue que uno de tus temas salga en el Top Semanal',
                'filename' => 'gidM281JesJTtogmJu7jv5Ayq9bAGUn.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Me gusta',
                'text' => 'Consigue tu primer voto positivo',
                'filename' => 'kKgjRhDTvXwx42F7BUa0HFLpxrZ3Ueu.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Make It Rain!',
                'text' => 'Consigue 1.000 votos positivos',
                'filename' => '5JCZmeL7IoN6Gmb5YB1XCFHvuTMdZgM.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Aspirante a influencer',
                'text' => 'Consigue 10.000 votos positivos',
                'filename' => 'CgGTFWcIBzu55B905uD12YEPjv0uk9i.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Ídolo de masas',
                'text' => 'Consigue 50.000 votos positivos',
                'filename' => 'Te3x5Yt3jP81QOXEc4NxaRepoSaIDIi.webp'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => 'Fuera de serie',
                'text' => 'Consigue estar en el Top Semanal',
                'filename' => 'N0cTuLBlBwe5eFB81uDqt5hXvt3rlzv.webp'
            ]
        ]);
    }
}
