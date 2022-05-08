<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type');
            $table->string('fuel_type');
            $table->integer('quantity');
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('truck_id')->nullable();
            $table->string('consumer_type');
            $table->unsignedBigInteger('price')->nullable();
            $table->unsignedBigInteger('operator_id');
            $table->text('comment')->nullable();
            $table->dateTime('datetime');
            $table->timestamps();

            $table->foreign('operator_id')->references('id')->on('employees');
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
        Schema::dropIfExists('fuel_transactions');
    }
};
