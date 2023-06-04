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
        Schema::disableForeignKeyConstraints();

        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->text('street_address');
            $table->string('city');
            $table->unsignedBigInteger('maximum_stage_width');
            $table->unsignedBigInteger('maximum_stage_depth');
            $table->unsignedBigInteger('maximum_stage_height');
            $table->unsignedBigInteger('maximum_seats');
            $table->unsignedBigInteger('maximum_wheelchair_seats');
            $table->unsignedBigInteger('number_of_dressing_rooms');
            $table->boolean('backstage_wheelchair_access');
            $table->foreignId('region_id')->constrained();
            $table->foreignId('venue_type_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
