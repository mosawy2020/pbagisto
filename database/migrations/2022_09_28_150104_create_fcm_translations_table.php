<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fcm_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale');
            $table->text('content')->nullable();
            $table->text('title')->nullable();
            $table->integer('fcm_id')->unsigned();
            $table->unique(['fcm_id', 'locale']);
            $table->foreign('fcm_id')->references('id')->on('fcms')->onDelete('cascade');
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
        Schema::dropIfExists('fcm_translations');
    }
};
