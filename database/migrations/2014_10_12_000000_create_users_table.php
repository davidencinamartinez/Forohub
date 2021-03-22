<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('verified')->default(false);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('about', 40)->default('Miembro de Forohub');
            $table->string('avatar', 100)->default('/src/avatars/Rj0pKZkZjnBUSreolKVwqxyXtwrIkF9.webp');
            $table->boolean('banned')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}
