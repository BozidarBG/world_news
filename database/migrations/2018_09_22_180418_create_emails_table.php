<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender')->index();
            $table->integer('receiver')->default(null)->index();
            $table->string('title')->default(null);
            $table->text('body')->default(null);
            $table->boolean('was_read')->default($value=0);
            $table->boolean('important_sender')->default($value=0);
            $table->boolean('important_receiver')->default($value=0);
            $table->boolean('is_draft')->default($value=0);
            $table->integer('trash_sender')->default($value=0);
            $table->integer('trash_receiver')->default($value=0);
            $table->integer('killed_sender')->default($value=0);
            $table->integer('killed_receiver')->default($value=0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
}
