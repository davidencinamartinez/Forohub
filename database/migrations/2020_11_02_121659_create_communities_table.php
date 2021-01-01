<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;

class CreateCommunitiesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('tag', 30);
            $table->string('title', 100);
            $table->string('description', 500);
            $table->string('logo', 100)->default('kZcTagGngsVeGl2Hsiy3ulhXOb78B4P.webp');
            $table->string('banner', 100)->nullable();
            $table->string('background', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communities');
    }
}
