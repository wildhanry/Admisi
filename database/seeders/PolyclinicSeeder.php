<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polyclinics = [
            [
                'code' => 'UMUM',
                'name' => 'Poli Umum',
                'description' => 'Pelayanan kesehatan umum untuk berbagai keluhan ringan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'GIGI',
                'name' => 'Poli Gigi',
                'description' => 'Pelayanan kesehatan gigi dan mulut',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'KIA',
                'name' => 'Poli KIA (Kesehatan Ibu dan Anak)',
                'description' => 'Pelayanan kesehatan ibu hamil, bayi, dan anak',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'MATA',
                'name' => 'Poli Mata',
                'description' => 'Pelayanan kesehatan mata',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'THT',
                'name' => 'Poli THT',
                'description' => 'Pelayanan kesehatan telinga, hidung, dan tenggorokan',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('polyclinics')->insert($polyclinics);
    }
}
