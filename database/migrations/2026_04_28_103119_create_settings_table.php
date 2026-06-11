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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('session'); // e.g 2024/2025

            // 🌐 Network rules
            $table->json('ip_config')->nullable();
            /*
                {
                    "restrict_ip": true,
                    "allowed_ip_patterns": ["192.168.1.*"]
                }
            */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
