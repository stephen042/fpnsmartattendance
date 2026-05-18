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
            $table->string('semester'); // First / Second

            // 🌐 Network rules
            $table->json('ip_config')->nullable();
            /*
                {
                    "restrict_ip": true,
                    "allowed_ip_patterns": ["192.168.1.*"]
                }
            */

            // 🎓 Departments
            $table->json('departments')->nullable();
            /*
                [
                    {"name": "Computer Science", "code": "CSC"},
                    {"name": "Statistics", "code": "STA"}
                ]
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
