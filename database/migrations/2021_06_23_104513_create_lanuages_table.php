<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanuagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lanuages', function (Blueprint $table) {
            $table->id();
            $table->string('abbr');
            $table->string('local')->nullable();
            $table->string('name');
            $table->enum('direction' , ['rtl','ltr'])->default('rtl');
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('lanuages');
    }
}
