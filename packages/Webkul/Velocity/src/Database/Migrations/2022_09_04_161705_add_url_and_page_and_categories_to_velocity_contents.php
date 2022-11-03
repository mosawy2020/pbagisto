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
        Schema::table('velocity_contents', function (Blueprint $table) {
            Schema::table('velocity_contents', function (Blueprint $table) {
                $table->text("url")->nullable()->default(null) ;
                $table->string("page")->nullable()->default(null) ;
                $table->string("categories")->nullable()->default(null) ;
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('velocity_contents', function (Blueprint $table) {
            $table->dropColumn(["url","page","categories"]);
        });
    }
};
