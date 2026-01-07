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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Kode Dokter');
            $table->string('name', 100)->comment('Nama Dokter');
            $table->string('specialization', 50)->comment('Spesialisasi');
            $table->string('license_number', 50)->unique()->comment('Nomor SIP/STR');
            $table->string('phone', 15)->nullable();
            $table->string('email', 100)->nullable();
            $table->foreignId('polyclinic_id')->nullable()->constrained('polyclinics')->onDelete('set null')->comment('Poli Utama');
            $table->json('schedule')->nullable()->comment('Jadwal Praktik (JSON format)');
            $table->boolean('is_active')->default(true)->comment('Status Aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index('specialization');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
