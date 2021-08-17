<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{

    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('location')->nullable();
            $table->string('image_name')->nullable();
            $table->string('date');
            $table->string('time');

            $table->BigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->BigInteger('county_id')->unsigned();
            $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');

            $table->BigInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('event_types')->onDelete('cascade');

            $table->BigInteger('object_id')->unsigned()->nullable();
            $table->foreign('object_id')->references('id')->on('objects')->onDelete('cascade');

            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('events');
    }
}
