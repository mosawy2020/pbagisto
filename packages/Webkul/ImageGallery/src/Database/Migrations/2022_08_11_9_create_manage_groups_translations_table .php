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
        Schema::create('manage_group_translations', function (Blueprint $table) {
            $table->id();
            $table->text('banner_text')->nullable();
            $table->integer('manage_group_id')->unsigned();
            $table->foreign('manage_group_id')->references('id')->on('manage_groups')->onDelete('cascade');
            $table->string("locale")->nullable();
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
        Schema::dropIfExists('manage_group_translations');
    }
};
