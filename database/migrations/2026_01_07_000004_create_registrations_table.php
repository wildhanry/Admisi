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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number', 30)->unique()->comment('Nomor Registrasi - Auto Generated');
            $table->string('queue_number', 10)->nullable()->comment('Nomor Antrian');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('polyclinic_id')->constrained('polyclinics')->onDelete('cascade');
            $table->enum('registration_type', ['RAWAT_JALAN', 'RAWAT_INAP', 'IGD'])
                ->default('RAWAT_JALAN')
                ->comment('Tipe Pendaftaran');
            $table->enum('payment_method', ['UMUM', 'BPJS', 'ASURANSI'])
                ->default('UMUM')
                ->comment('Metode Pembayaran');
            $table->string('insurance_number', 50)->nullable()->comment('Nomor BPJS/Asuransi');
            $table->date('registration_date')->comment('Tanggal Pendaftaran');
            $table->time('registration_time')->comment('Waktu Pendaftaran');
            $table->enum('status', ['MENUNGGU', 'DIPERIKSA', 'SELESAI', 'BATAL'])
                ->default('MENUNGGU')
                ->comment('Status Pendaftaran');
            $table->text('complaint')->nullable()->comment('Keluhan Pasien');
            $table->text('notes')->nullable()->comment('Catatan Tambahan');
            $table->foreignId('registered_by')->nullable()->constrained('users')->onDelete('set null')->comment('Petugas Pendaftaran');
            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk optimasi query
            $table->index('registration_number');
            $table->index('registration_date');
            $table->index('status');
            $table->index(['registration_type', 'registration_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
