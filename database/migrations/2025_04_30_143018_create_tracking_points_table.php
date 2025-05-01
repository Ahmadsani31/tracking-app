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
        Schema::create('tracking_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracking_session_id')->constrained('tracking_sessions', 'id')->cascadeOnDelete();
            $table->decimal('latitude', 10, 7);      // Koordinat latitude
            $table->decimal('longitude', 10, 7);     // Koordinat longitude
            $table->timestamp('recorded_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_points');
    }
};
