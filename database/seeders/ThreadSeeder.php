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
            'body' => '<div class="picture"><img src="/src/threads/329LN6IINxnaOmXPzAN7pF5WR3pummFq.webp"></div><marquee behavior="scroll" direction="left" scrollamount="10" onmouseover="stop()" onmouseleave="start()">Bienvenidos a tod@s!!! Disfrutad de vuestra estancia 😁😁😁</marquee>',
        ]);
        DB::table('threads')->insert([
            'created_at' => Carbon::now()->sub('11 hours 10 minutes'),
            'updated_at' => Carbon::now()->sub('11 hours 10 minutes'),
            'community_id' => 11071968,
            'user_id' => 24111998,
            'title' => 'Mi hamburguesa casera GORDURA INSAID',
            'body' => '<div class="picture"><img src="https://i.imgur.com/l7RKj1r.jpg"></div><marquee behavior="scroll" direction="left" scrollamount="10" onmouseover="stop()" onmouseleave="start()">Morid de envidia veganos</marquee>',
        ]);
        DB::table('threads')->insert([
            'created_at' => Carbon::now()->sub('1 day 4 hours'),
            'updated_at' => Carbon::now()->sub('1 day 4 hours'),
            'community_id' => 11071968,
            'user_id' => 24112001,
            'nsfw' => 1,
            'title' => 'Osloco?',
            'body' => '<div class="picture blurry"><img src="https://static.ideal.es/granada/noticias/201310/26/Media/volcado/hot-food--647x300.jpg"></div><marquee behavior="scroll" direction="left" scrollamount="10" onmouseover="stop()" onmouseleave="start()">🤤🤤🤤</marquee>',
        ]);
        DB::table('threads')->insert([
            'created_at' => Carbon::now()->sub('1 day 2 hours 40 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 2 hours 40 minutes'),
            'community_id' => 11071969,
            'user_id' => 24111999,
            'title' => 'Bugatti Volide (2021)',
            'body' => '<div class="picture"><img src="https://soymotor.com/sites/default/files/usuarios/redaccion/portal/redaccion/bugatti-bolide-paul-soymotor.jpg"></div><marquee behavior="scroll" direction="left" scrollamount="10" onmouseover="stop()" onmouseleave="start()">Que ganas de probarlo en el Forza... Porque en la vida real no voy a poder oler algo así ni en 100 años...</marquee>',
        ]);
        DB::table('threads')->insert([
            'created_at' => Carbon::now()->sub('1 day 2 hours 20 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 2 hours 20 minutes'),
            'community_id' => 11071970,
            'user_id' => 24112000,
            'title' => 'Primer hilo de gatos',
            'body' => '<div class="media-embed"><iframe width="560" height="315" src="https://www.youtube.com/embed/DXUAyRRkI6k" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe></div>',
        ]);
        DB::table('threads')->insert([
            'created_at' => Carbon::now()->sub('11 hours 40 minutes'),
            'updated_at' => Carbon::now()->sub('11 hours 40 minutes'),
            'community_id' => 11071971,
            'user_id' => 24112001,
            'title' => 'Configuración PC - 1500€',
            'body' => 'Hola shurs, A ver si me podéis echar un cable. Presupuesto: 1.500€ (ligeramente estirable) Uso: juegos + trabajo (autocad, revit, etc). No OC.',
        ]);
        DB::table('threads')->insert([
            'created_at' => Carbon::now()->sub('5 hours'),
            'updated_at' => Carbon::now()->sub('5 hours'),
            'community_id' => 11071972,
            'user_id' => 24111999,
            'title' => 'JDM Trasera a buen precio?',
            'body' => 'Buenas shures, Ando pensando en un proyectilo para drift y tandas sobretodo, y busco un JDM (Ya que adoro los japoneses) que sea trasera y decente. ¿Cuál me recomendais? Andaba pensando en como máximo unos 10k€ Saludos a la pole',
        ]);
        DB::table('threads')->insert([
            'created_at' => Carbon::now()->sub('3 hours'),
            'updated_at' => Carbon::now()->sub('3 hours'),
            'community_id' => 11071969,
            'user_id' => 24111999,
            'title' => 'Qué opináis de esto?',
            'body' => '<div class="picture"><img src="https://i.imgur.com/XLs2Pw6.jpg"></div>',
        ]);
    }
}
