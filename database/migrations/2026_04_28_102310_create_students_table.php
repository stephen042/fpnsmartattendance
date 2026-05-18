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

            // 🔑 Login identity
            $table->string('application_number')->unique();
            $table->string('reg_number')->unique();

            // 🎓 Academic info
            $table->string('full_name');
            $table->string('email')->nullable()->unique();
            $table->string('department');
            $table->string('level'); // ND1, HND1 etc
            $table->string('program'); // M, E, W  etc
            $table->string('option')->nullable(); // SWD, NCC etc

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
