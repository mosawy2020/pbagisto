<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVelocityMetaData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('velocity_meta_data', function (Blueprint $table) {
            $table->increments('id');
            $table->text('home_page_content')->nullable();
            $table->text('home_page_apps')->nullable();
            $table->text('usage_description')->nullable();
            $table->text('home_page_about')->nullable();
            $table->text('usage_title')->nullable();
            $table->text('usage_items')->nullable();
            $table->text('text_ad')->nullable();
            $table->text('advertisment_texts')->nullable();
            $table->text('footer_first_section')->nullable();
            $table->text('footer_second_section')->nullable();
            $table->text('footer_third_section')->nullable();
            $table->text('footer_logo')->nullable();
            $table->text('color')->nullable();
            $table->text('footer_left_content')->nullable();
            $table->text('footer_middle_content')->nullable();
            $table->boolean('slider')->default(0);
            $table->json('advertisement')->nullable();
            $table->integer('sidebar_category_count')->default(9);
            $table->integer('featured_product_count')->default(10);
            $table->integer('new_products_count')->default(10);
            $table->text('subscription_bar_content')->nullable();
            $table->text('header_content_count')->nullable();
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
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
        Schema::dropIfExists('velocity_meta_data');
    }
}
