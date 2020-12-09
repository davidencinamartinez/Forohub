<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class CommunitySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // DEFAULT LOGO
        $array_logo = array('kZcTagGngsVeGl2Hsiy3ulhXOb78B4P.webp', 'eGnn3FMGoKcoX62J8zGhgR7aNixpcsJ.webp', '0cuELPS1EZmWE47HDp7ErnQ9MTJh8t3.webp', 'jXXOFbrp1va0mVf848keyYehdVLmMLj.webp', 'k3M5OsDTCldfSu8wYwfsoz3izXVSGua.webp', 'hyQnGEFrUkQUf38TzboyTq0I1UWhsAI.webp', 'JXieeAuxONvBi5BAHW0GerugoXxUlqL.webp', 'UQ5jb6P2u1Et5YkhF3mXFg8cXi79Agq.webp');

    	// COMMUNITIES
        DB::table('communities')->insert([
            'id' => 11071967,
            'created_at' => Carbon::now()->sub('1 day 22 hours 30 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 22 hours 30 minutes'),
        	'tag' => 'forohub',
            'title' => 'ForoHub - Oficial',
            'description' => 'Comunicados oficiales de ForoHub',
            'logo' => 's2HGcJxofEphgzMYmZvPnRlQi1Admxl.webp',
        ]);
        DB::table('communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 5 hours'),
            'updated_at' => Carbon::now()->sub('1 day 5 hours'),
            'tag' => 'foodporn',
            'title' => 'Food Porn',
            'description' => 'Pongamos aquí nuestras delicias más dulces',
            'logo' => 'Mn1uYQpJRjahK905oCuRAD7JPSDMRjh.webp'
        ]);
        DB::table('communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 4 hours 10 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 4 hours 10 minutes'),
            'tag' => 'supercoches',
            'title' => 'Supercoches',
            'description' => 'A 280 no tengo amigos',
            'logo' => '4BcaiQYi50mSuizPM8LI1WYovP7Sty9.webp',
            'background' => 'ObmG5qIEcIZkMtWqEGVFXmkdlwlqSeQx.jpg'
        ]);
        DB::table('communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 2 hours 50 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 2 hours 50 minutes'),
            'tag' => 'gatitos',
            'title' => 'Gatos - Mewww',
            'description' => 'Nuestros mejores y peludos amigos',
            'logo' => 'e3RI92gixW1kMgv3zE8xvRaOfteG6eF.webp'
        ]);
        DB::table('communities')->insert([
            'created_at' => Carbon::now()->sub('15 hours 40 minutes'),
            'updated_at' => Carbon::now()->sub('15 hours 40 minutes'),
            'tag' => 'deepweb',
            'title' => 'Deep Web',
            'description' => 'Dark Web Content (NSFW, Gore, Etc...)',
            'logo' => '2lEJIHUsECujkljokF2oyCA6KekxFfv.webp'
        ]);
        DB::table('communities')->insert([
            'created_at' => Carbon::now()->sub('15 hours 20 minutes'),
            'updated_at' => Carbon::now()->sub('15 hours 20 minutes'),
            'tag' => 'jdmretro',
            'title' => 'JDM Retro',
            'description' => 'Running in the 90s',
            'logo' => 'zhxYn3UKnOf9PYLyLfrubCU4vXgokUA.webp'
        ]);

        // COMMUNITIY RULES
        DB::table('communities_rules')->insert([
            'created_at' => Carbon::now()->sub('1 day 22 hours 10 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 22 hours 10 minutes'),
        	'community_id' => 11071967,
            'rule' => 'Sé bueno',
            'rule_description' => 'El usuario acepta usar los servicios de ForoHub de forma consciente y libre, con intenciones lícitas y de buena fe. Siendo el único responsable de tus actos, exonerando de toda responsabilidad por los mismos a los gestores o colaboradores de ForoHub',
        ]);
        DB::table('communities_rules')->insert([
            'created_at' => Carbon::now()->sub('1 day 22 hours 5 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 22 hours 5 minutes'),
        	'community_id' => 11071967,
            'rule' => 'Respeta a los demás usuarios',
            'rule_description' => 'Se puede opinar, debatir y discutir sobre cualquier tema que tenga cabida, pero con el respeto a los demás usuarios como regla principal',
        ]);

        // COMMUNITY WIKI
        DB::table('communities_wiki')->insert([
            'created_at' => Carbon::now()->sub('1 day 21 hours 50 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 21 hours 50 minutes'),
        	'community_id' => 11071967,
            'body' => '<b>Esto es una Wiki de testeo</b>',
        ]);

        // COMMUNITY USERS
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 22 hours 30 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 22 hours 30 minutes'),
        	'community_id' => 11071967,
            'user_id' => 24111997,
            'subscription_type' => 5000
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 3 hours 10 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 3 hours 10 minutes'),
            'community_id' => 11071967,
            'user_id' => 24111998,
            'subscription_type' => 0
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 2 hours 30 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 2 hours 30 minutes'),
            'community_id' => 11071967,
            'user_id' => 24111999,
            'subscription_type' => 0
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 2 hours 20 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 2 hours 20 minutes'),
            'community_id' => 11071967,
            'user_id' => 24112000,
            'subscription_type' => 0
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 5 hours'),
            'updated_at' => Carbon::now()->sub('1 day 5 hours'),
            'community_id' => 11071968,
            'user_id' => 24111998,
            'subscription_type' => 5000
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 4 hours 10 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 4 hours 10 minutes'),
            'community_id' => 11071969,
            'user_id' => 24111999,
            'subscription_type' => 5000
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 2 hours 50 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 2 hours 50 minutes'),
            'community_id' => 11071970,
            'user_id' => 24112000,
            'subscription_type' => 5000
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('12 hours'),
            'updated_at' => Carbon::now()->sub('12 hours'),
            'community_id' => 11071971,
            'user_id' => 24112001,
            'subscription_type' => 5000
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('11 hours 30 minutes'),
            'updated_at' => Carbon::now()->sub('11 hours 30 minutes'),
            'community_id' => 11071968,
            'user_id' => 24112001,
            'subscription_type' => 0
        ]);
        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('10 hours'),
            'updated_at' => Carbon::now()->sub('10 hours'),
            'community_id' => 11071972,
            'user_id' => 24111998,
            'subscription_type' => 5000
        ]);
    }
}
