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

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_type');
            $table->json('old_data');
            $table->json('new_data');
            $table->foreignId('user_id')->constrained();
            $table->unsignedBigInteger('loggable_id');
            $table->string('loggable_type');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
