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
        Schema::create('journey_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journey_id');
            $table->string('type');
            $table->string('name');
            $table->unsignedBigInteger('amount');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('journey_id')->references('id')->on('journeys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journey_transactions');
    }
};
