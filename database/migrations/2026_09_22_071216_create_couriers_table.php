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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->unsignedTinyInteger('level'); // 1-5
            $table->string('vehicle_type')->nullable(); // motor, mobil, sepeda
            $table->string('vehicle_plate_number')->nullable();
            $table->string('license_number')->nullable(); // no. SIM
            $table->text('address')->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->date('joined_at'); // tanggal didaftarkan
            $table->timestamps();

            $table->index('name');
            $table->index('level');
            $table->index('joined_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
