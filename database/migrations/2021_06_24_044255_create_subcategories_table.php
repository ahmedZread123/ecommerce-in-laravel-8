<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->string('translation_lang');
            $table->integer('translation_of');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('photo')->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('main_categories');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategories');
    }
}
