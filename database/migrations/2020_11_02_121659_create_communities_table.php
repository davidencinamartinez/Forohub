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
            $table->string('title', 50);
            $table->string('description', 500);
            $table->string('logo', 200)->default('https://res.cloudinary.com/dt4uoou5x/image/upload/v1612615521/kZcTagGngsVeGl2Hsiy3ulhXOb78B4P_onapy0.webp');
            $table->string('banner', 200)->nullable();
            $table->string('background', 200)->nullable();
            $table->boolean('closed')->default(0);
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
