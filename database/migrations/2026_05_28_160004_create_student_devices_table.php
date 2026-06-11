<?php

use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('student_devices', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('student_id')->constrained()->cascadeOnDelete();
    //         $table->string('device_hash')->nullable();
    //         $table->string('device_name')->nullable();
    //         $table->text('device_screen_hash')->nullable();
    //         $table->string('device_user_agent')->nullable();
    //         $table->string('device_local_token')->nullable();
    //         $table->string('last_ip')->nullable();
    //         $table->timestamp('last_login_at')->nullable();
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('student_devices');
    // }
};
