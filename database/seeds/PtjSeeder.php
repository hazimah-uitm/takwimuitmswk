<?php

use App\Models\Ptj;
use Illuminate\Database\Seeder;

class PtjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ptj::insert([
            [
                'name' => 'BAHAGIAN INFOSTRUKTUR',
                'type' => 'Pentadbiran',
                'publish_status' => true
            ],
            [
                'name' => 'BAHAGIAN HAL EHWAL AKADEMIK & ANTARABANGSA',
                'type' => 'Pentadbiran',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI ALAM BINA',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI PERLADANGAN & AGROTEKNOLOGI',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI SENI REKA GRAFIK & MEDIA DIGITAL',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI KEJURUTERAAN KIMIA',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI KEJURUTERAAN ELEKTRIK (ELEKTRONIK)',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI PENGURUSAN MAKLUMAT',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI PERAKAUNAN',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI PENGURUSAN DAN PERNIAGAAN',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI SAINS KESIHATAN',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI SAINS SUKAN & REKREASI',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI KESIHATAN PERSEKITARAN',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI KEJURUTERAAN AWAM',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI SAINS KOMPUTER & MATEMATIK',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI SAINS GUNAAN',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI SAINS PENTADBIRAN & PENGAJIAN POLISI',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'AKADEMI PENGAJIAN ISLAM KONTEMPORARI (ACIS)',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI PENGURUSAN HOTEL & PELANCONGAN',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'FAKULTI UNDANG-UNDANG',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'SERVICING (APB, ACIS, PERAKAUNAN, & UNDANG-UNDANG)',
                'type' => 'Akademik',
                'publish_status' => true
            ],
            [
                'name' => 'AKADEMI PENGAJIAN BAHASA',
                'type' => 'Akademik',
                'publish_status' => true
            ]
        ]);
    }
}
