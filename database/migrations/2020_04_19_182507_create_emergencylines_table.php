<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencylinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergencylines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('emergencylinecategory_id');
            $table->string('name');
            $table->string('telephone_number');
            $table->mediumText('description')->nullable();
            $table->timestamps();

            $table->foreign('emergencylinecategory_id')->references('id')->on('emergencyline_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergencylines');
    }
}
