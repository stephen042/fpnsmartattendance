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

        Schema::create('ip_restrictions', function (Blueprint $table) {
            $table->id();
            $table->string('ip_pattern'); // e.g. 192.168.1.*, 10.0.0.1/24, or exact IP
            $table->string('label')->nullable(); // e.g. "Main Lab 1", "ICT Center"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_restrictions');
    }
};
