<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('map_id')->unsigned();
            $table->integer('order')->default(100);
            $table->integer('source_id')->unsigned();
            $table->boolean('visible')->default(true);
            $table->integer('opacity')->default(10);
            $table->string('type');
            $table->integer('minzoom')->default(1);
            $table->integer('maxzoom')->default(22);
            $table->boolean('interactive')->default(false);
            $table->text('filter');
            $table->text('paint');
            $table->timestamps();

            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('layers');
    }
}
