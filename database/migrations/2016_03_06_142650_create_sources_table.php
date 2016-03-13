<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origin_type', 20);
            $table->text('origin_url');
            $table->string('origin_format')->nullable();
            $table->integer('origin_size')->nullable();

            $table->string('name');
            $table->text('description');
            $table->text('web');

            $table->string('sync_status', 20);
            $table->string('sync_interval', 20);
            $table->timestamp('synced_at')->nullable();
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
        Schema::drop('sources');
    }
}
