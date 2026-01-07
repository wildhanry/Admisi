<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'code' => 'DR001',
                'name' => 'dr. Ahmad Wijaya, Sp.PD',
                'specialization' => 'Spesialis Penyakit Dalam',
                'license_number' => 'SIP-001-2024',
                'phone' => '081234567801',
                'email' => 'ahmad.wijaya@klinik.com',
                'polyclinic_id' => 1, // Poli Umum
                'schedule' => json_encode([
                    'Senin' => ['available' => true, 'start' => '08:00', 'end' => '12:00'],
                    'Rabu' => ['available' => true, 'start' => '08:00', 'end' => '12:00'],
                    'Jumat' => ['available' => true, 'start' => '08:00', 'end' => '12:00'],
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'DR002',
                'name' => 'dr. Siti Nurhaliza',
                'specialization' => 'Dokter Umum',
                'license_number' => 'SIP-002-2024',
                'phone' => '081234567802',
                'email' => 'siti.nurhaliza@klinik.com',
                'polyclinic_id' => 1, // Poli Umum
                'schedule' => json_encode([
                    'Selasa' => ['available' => true, 'start' => '08:00', 'end' => '14:00'],
                    'Kamis' => ['available' => true, 'start' => '08:00', 'end' => '14:00'],
                    'Sabtu' => ['available' => true, 'start' => '08:00', 'end' => '12:00'],
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'DR003',
                'name' => 'drg. Budi Santoso, Sp.KG',
                'specialization' => 'Spesialis Konservasi Gigi',
                'license_number' => 'SIP-003-2024',
                'phone' => '081234567803',
                'email' => 'budi.santoso@klinik.com',
                'polyclinic_id' => 2, // Poli Gigi
                'schedule' => json_encode([
                    'Senin' => ['available' => true, 'start' => '13:00', 'end' => '17:00'],
                    'Rabu' => ['available' => true, 'start' => '13:00', 'end' => '17:00'],
                    'Jumat' => ['available' => true, 'start' => '13:00', 'end' => '17:00'],
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'DR004',
                'name' => 'dr. Rina Kusuma, Sp.OG',
                'specialization' => 'Spesialis Obstetri dan Ginekologi',
                'license_number' => 'SIP-004-2024',
                'phone' => '081234567804',
                'email' => 'rina.kusuma@klinik.com',
                'polyclinic_id' => 3, // Poli KIA
                'schedule' => json_encode([
                    'Selasa' => ['available' => true, 'start' => '09:00', 'end' => '13:00'],
                    'Kamis' => ['available' => true, 'start' => '09:00', 'end' => '13:00'],
                    'Sabtu' => ['available' => true, 'start' => '09:00', 'end' => '12:00'],
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'DR005',
                'name' => 'dr. Hendra Pratama, Sp.M',
                'specialization' => 'Spesialis Mata',
                'license_number' => 'SIP-005-2024',
                'phone' => '081234567805',
                'email' => 'hendra.pratama@klinik.com',
                'polyclinic_id' => 4, // Poli Mata
                'schedule' => json_encode([
                    'Senin' => ['available' => true, 'start' => '10:00', 'end' => '14:00'],
                    'Rabu' => ['available' => true, 'start' => '10:00', 'end' => '14:00'],
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('doctors')->insert($doctors);
    }
}
