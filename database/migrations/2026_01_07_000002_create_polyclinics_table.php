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
        Schema::create('polyclinics', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Kode Poli');
            $table->string('name', 100)->comment('Nama Poli');
            $table->text('description')->nullable()->comment('Deskripsi Poli');
            $table->boolean('is_active')->default(true)->comment('Status Aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polyclinics');
    }
};
