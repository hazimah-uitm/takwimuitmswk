<?php

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::insert([
            [
                'title' => 'PENOLONG PENDAFTAR KANAN',
                'grade' => 'N10',
                'publish_status' => true
            ],
            [
                'title' => 'PENOLONG PENDAFTAR',
                'grade' => 'N9',
                'publish_status' => true
            ],
            [
                'title' => 'TIMBALAN BENDAHARI',
                'grade' => 'WA12',
                'publish_status' => true
            ],
            [
                'title' => 'PEGAWAI PSIKOLOGI KANAN',
                'grade' => 'S10',
                'publish_status' => true
            ],
            [
                'title' => 'PEGAWAI TEKNOLOGI MAKLUMAT',
                'grade' => 'F9',
                'publish_status' => true
            ],
            [
                'title' => 'JURUTERA KANAN',
                'grade' => 'J10',
                'publish_status' => true
            ],
            [
                'title' => 'TIMBALAN PEGAWAI KESELAMATAN',
                'grade' => 'KP12',
                'publish_status' => true
            ],
            [
                'title' => 'PEGAWAI PERTANIAN KANAN',
                'grade' => 'G10',
                'publish_status' => true
            ],
            [
                'title' => 'TIMBALAN PENDAFTAR KANAN',
                'grade' => 'N13',
                'publish_status' => true
            ],
            [
                'title' => 'PEGAWAI EKSEKUTIF KANAN',
                'grade' => 'N6',
                'publish_status' => true
            ],
            [
                'title' => 'TIMBALAN PEGAWAI SUKAN',
                'grade' => 'S12',
                'publish_status' => true
            ],
            [
                'title' => 'PEGAWAI PERUBATAN',
                'grade' => 'UD14',
                'publish_status' => true
            ],
            [
                'title' => 'PEGAWAI HAL EHWAL ISLAM KANAN',
                'grade' => 'S10',
                'publish_status' => true
            ],
            [
                'title' => 'TIMBALAN KETUA PUSTAKAWAN',
                'grade' => 'S12',
                'publish_status' => true
            ],
            [
                'title' => 'PENOLONG PEGAWAI KEBUDAYAAN',
                'grade' => 'B5',
                'publish_status' => true
            ],
            [
                'title' => 'PENSYARAH',
                'grade' => 'DS11',
                'publish_status' => true
            ],
            [
                'title' => 'PENSYARAH KANAN',
                'grade' => 'DS13',
                'publish_status' => true
            ],
            [
                'title' => 'PROFESOR',
                'grade' => 'VK7',
                'publish_status' => true
            ],
            [
                'title' => 'PROFESOR MADYA',
                'grade' => 'DS14',
                'publish_status' => true
            ],
        ]);
    }
}
