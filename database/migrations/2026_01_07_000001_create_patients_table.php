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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm', 20)->unique()->comment('Nomor Rekam Medis - Auto Generated');
            $table->string('nik', 16)->unique()->comment('NIK Pasien');
            $table->string('name', 100)->comment('Nama Lengkap Pasien');
            $table->date('date_of_birth')->comment('Tanggal Lahir');
            $table->enum('gender', ['L', 'P'])->comment('L=Laki-laki, P=Perempuan');
            $table->text('address')->comment('Alamat Lengkap');
            $table->string('phone', 15)->nullable()->comment('Nomor Telepon');
            $table->string('blood_type', 3)->nullable()->comment('Golongan Darah');
            $table->string('emergency_contact_name', 100)->nullable()->comment('Nama Kontak Darurat');
            $table->string('emergency_contact_phone', 15)->nullable()->comment('Telepon Kontak Darurat');
            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk optimasi query
            $table->index('nik');
            $table->index('no_rm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
