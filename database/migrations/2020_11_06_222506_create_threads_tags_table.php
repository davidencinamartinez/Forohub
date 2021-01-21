<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads_tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('thread_id');
            $table->foreign('thread_id')->references('id')->on('threads');
            $table->string('tagname', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads_tags');
    }
}
