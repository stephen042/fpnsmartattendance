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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('application_number')->unique();
            $table->string('matric_number')->unique()->nullable();

            $table->string('full_name');

            $table->string('email')
                ->nullable()
                ->unique()->nullable();

            $table->string('phone')
                ->nullable();

            $table->enum('gender', [
                'male',
                'female'
            ])->nullable();

            $table->foreignId('department_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('level_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('programme_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('course_option_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // $table->string('password');

            // 🔐 Security
            $table->string('device_hash')->nullable();
            $table->string('device_name')->nullable();
            $table->boolean('device_locked')->default(false);
            $table->string('device_user_agent')->nullable();
            $table->text('device_screen_hash')->nullable();
            $table->string('device_local_token')->nullable();
            $table->timestamp('device_locked_until')->nullable();

            $table->string('last_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->boolean('is_active')->default(true);

            // 🧾 Flexible
            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
