<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash',4)->unique();
            $table->integer('user_id')->unsigned();

            $table->boolean('active')->default(true);
            $table->string('visibility', 20);
            $table->string('name');
            $table->text('description');

            $table->string('style');
            $table->decimal('longitude',11,8);
            $table->decimal('latitude',10,8);
            $table->integer('zoom');
            $table->integer('pitch');
            $table->integer('bearing');

            $table->integer('views');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('maps');
    }
}
