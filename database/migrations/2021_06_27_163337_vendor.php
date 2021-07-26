<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Vendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('mobile');
            $table->text('password');
            $table->unsignedBigInteger('subcategory_id');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->text('address');
            $table->tinyInteger('active')->default(0);
            $table->string('logo');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('main_categories');
            $table->foreign('subcategory_id')->references('id')->on('subcategories');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
