<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesWikiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities_wiki', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('community_id');
            $table->foreign('community_id')->references('id')->on('communities');
            $table->longText('body', 30000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities_wiki');
    }
}
