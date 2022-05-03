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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journey_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('truck_id');
            $table->unsignedBigInteger('locality_from_id');
            $table->unsignedBigInteger('locality_to_id');
            $table->string('status');
            $table->unsignedInteger('mileage');
            $table->unsignedInteger('fuel_remains')->nullable();
            $table->unsignedInteger('fuel_refill')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('finish_time');
            $table->timestamps();

            $table->foreign('journey_id')->references('id')->on('journeys');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('locality_from_id')->references('id')->on('localities');
            $table->foreign('locality_to_id')->references('id')->on('localities');
            $table->foreign('truck_id')->references('id')->on('trucks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip');
    }
};
