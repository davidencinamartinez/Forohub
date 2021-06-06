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

    	// COMMUNITY

        DB::table('communities')->insert([
            'id' => 11071967,
            'created_at' => Carbon::now()->sub('1 day 22 hours 30 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 22 hours 30 minutes'),
        	'tag' => 'forohub',
            'title' => 'Forohub - Oficial',
            'description' => 'Comunicados oficiales de Forohub',
            'logo' => '/src/communities/logo/s2HGcJxofEphgzMYmZvPnRlQi1Admxl.webp',
        ]);

        // COMMUNITIY RULES

        DB::table('communities_rules')->insert([
            'created_at' => Carbon::now()->sub('1 day 22 hours 10 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 22 hours 10 minutes'),
        	'community_id' => 11071967,
            'rule' => 'Sé bueno',
            'rule_description' => 'El usuario acepta usar los servicios de Forohub de forma consciente y libre, con intenciones lícitas y de buena fe. Siendo el único responsable de sus actos, exonerando de toda responsabilidad por los mismos a los gestores o colaboradores de Forohub',
        ]);
        DB::table('communities_rules')->insert([
            'created_at' => Carbon::now()->sub('1 day 22 hours 5 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 22 hours 5 minutes'),
        	'community_id' => 11071967,
            'rule' => 'Respeta a los demás usuarios',
            'rule_description' => 'Se puede opinar, debatir y discutir sobre cualquier tema que tenga cabida, pero con el respeto a los demás usuarios como regla principal',
        ]);

        // COMMUNITY USERS

        DB::table('users_communities')->insert([
            'created_at' => Carbon::now()->sub('1 day 22 hours 30 minutes'),
            'updated_at' => Carbon::now()->sub('1 day 22 hours 30 minutes'),
        	'community_id' => 11071967,
            'user_id' => 24111997,
            'subscription_type' => 5000
        ]);
        
        // COMMUNITY TAGS

        DB::table('communities_tags')->insert([
            [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'community_id' => 11071967,
                'tagname' => 'forohub'
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'community_id' => 11071967,
                'tagname' => 'oficial'
            ]
        ]);
    }
}
