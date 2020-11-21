<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities_rules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('community_id');
            $table->foreign('community_id')->references('id')->on('communities');
            $table->string('rule', 60);
            $table->string('rule_description', 300)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities_rules');
    }
}
