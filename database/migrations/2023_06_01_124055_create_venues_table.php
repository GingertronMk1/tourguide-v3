<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->text('notes');
            $table->text('street_address');
            $table->string('city');
            $table->unsignedBigInteger('maximum_stage_width');
            $table->unsignedBigInteger('maximum_stage_depth');
            $table->unsignedBigInteger('maximum_stage_height');
            $table->unsignedBigInteger('maximum_seats');
            $table->unsignedBigInteger('maximum_wheelchair_seats');
            $table->unsignedBigInteger('number_of_dressing_rooms');
            $table->boolean('backstage_wheelchair_access');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
