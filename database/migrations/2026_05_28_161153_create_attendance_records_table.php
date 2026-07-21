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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('attendance_session_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();

            // ⬇️ SNAPSHOT DATA (IMPORTANT)
            $table->string('full_name');
            $table->string('application_number')->nullable();
            $table->string('matric_number')->nullable();

            $table->string('department_name')->nullable();
            $table->string('level_name')->nullable();
            $table->string('programme_name')->nullable();
            $table->string('course_option_name')->nullable();

            // attendance details
            $table->timestamp('signed_in_at');
            $table->enum('status', ['present', 'absent', 'suspended'])->default('present');

            // location tracking
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('verified_geolocation')->default(false);

            // device security
            $table->string('device_hash')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
