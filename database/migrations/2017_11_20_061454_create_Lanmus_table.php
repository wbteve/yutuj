<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanmusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Lanmus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedTinyInteger('hide')->default(0);
            $table->unsignedTinyInteger('parent_id')->default(0);
            $table->unsignedTinyInteger('order')->default(0);
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
        Schema::dropIfExists('Lanmus');
    }
}
