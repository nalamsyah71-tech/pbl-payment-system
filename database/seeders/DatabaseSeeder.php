<?php

namespace Database\Seeders;

use App\Models\Kejuruan;
use App\Models\Kelas;
use App\Models\Pelatihan;
use App\Models\Peserta;  // Ganti Pesertas jadi Peserta
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        // =================== KEJURUAN ===================
        $kejuruans = [
            'Teknik Komputer dan Jaringan',
            'Teknik Kendaraan Ringan',
            'Teknik Pengelasan',
            'Tata Busana',
            'Tata Boga',
        ];

        foreach ($kejuruans as $nama) {
            Kejuruan::create(['nama' => $nama]);
        }

        // =================== PELATIHAN ===================
        $kejTKJ   = Kejuruan::where('nama', 'Teknik Komputer dan Jaringan')->first();
        $kejOtomo = Kejuruan::where('nama', 'Teknik Kendaraan Ringan')->first();
        $kejLas   = Kejuruan::where('nama', 'Teknik Pengelasan')->first();

        $pelatihans = [
            ['kejuruan_id' => $kejTKJ->id,   'nama' => 'Pelatihan Teknisi Komputer Dasar'],
            ['kejuruan_id' => $kejTKJ->id,   'nama' => 'Pelatihan Instalasi Jaringan LAN'],
            ['kejuruan_id' => $kejOtomo->id, 'nama' => 'Pelatihan Servis Motor Injeksi'],
            ['kejuruan_id' => $kejOtomo->id, 'nama' => 'Pelatihan Tune Up Mobil'],
            ['kejuruan_id' => $kejLas->id,   'nama' => 'Pelatihan Las SMAW Level I'],
        ];

        foreach ($pelatihans as $data) {
            Pelatihan::create($data);
        }

        // =================== KELAS ===================
        $pelTKJ1 = Pelatihan::where('nama', 'Pelatihan Teknisi Komputer Dasar')->first();
        $pelLas  = Pelatihan::where('nama', 'Pelatihan Las SMAW Level I')->first();

        $kelas1 = Kelas::create([
            'pelatihan_id' => $pelTKJ1->id,
            'nama_kelas'   => 'TKJ-A 2024',
            'tgl_mulai'    => '2024-03-04',
            'tgl_selesai'  => '2024-04-12',
            'hari_efektif' => 30,
            'mak_pulsa'    => '5210.PBL.01',
            'mak_asuransi' => '5211.PBL.01',
            'mak_uang_saku'=> '5212.PBL.01',
        ]);

        $kelas2 = Kelas::create([
            'pelatihan_id' => $pelLas->id,
            'nama_kelas'   => 'LAS-B 2024',
            'tgl_mulai'    => '2024-04-01',
            'tgl_selesai'  => '2024-05-10',
            'hari_efektif' => 28,
            'mak_pulsa'    => '5210.PBL.02',
            'mak_asuransi' => '5211.PBL.02',
            'mak_uang_saku'=> '5212.PBL.02',
        ]);

        // =================== PESERTA ===================
        $pesertaKelas1 = [
            ['nik' => '3201010101010001', 'nama' => 'AHMAD FAUZI',       'no_hp' => '081234567890', 'bank' => 'BRI', 'nomor_rekening' => '123456789012', 'hari_kehadiran' => 28],
            ['nik' => '3201010101010002', 'nama' => 'BUDI SANTOSO',      'no_hp' => '082234567891', 'bank' => 'BNI', 'nomor_rekening' => '223456789013', 'hari_kehadiran' => 30],
            ['nik' => '3201010101010003', 'nama' => 'CITRA DEWI',        'no_hp' => '083334567892', 'bank' => 'BRI', 'nomor_rekening' => '323456789014', 'hari_kehadiran' => 25],
            ['nik' => '3201010101010004', 'nama' => 'DIAN PERMATA',      'no_hp' => '084434567893', 'bank' => 'MANDIRI', 'nomor_rekening' => '423456789015', 'hari_kehadiran' => 29],
            ['nik' => '3201010101010005', 'nama' => 'EKO PRASETYO',      'no_hp' => '085534567894', 'bank' => 'BRI', 'nomor_rekening' => '523456789016', 'hari_kehadiran' => 30],
            ['nik' => '3201010101010006', 'nama' => 'FITRI RAHAYU',      'no_hp' => '086634567895', 'bank' => 'BTN', 'nomor_rekening' => '623456789017', 'hari_kehadiran' => 27],
            ['nik' => '3201010101010007', 'nama' => 'GUNAWAN WIJAYA',    'no_hp' => '087734567896', 'bank' => 'BRI', 'nomor_rekening' => '723456789018', 'hari_kehadiran' => 30],
            ['nik' => '3201010101010008', 'nama' => 'HENDRA KUSUMA',     'no_hp' => '088834567897', 'bank' => 'MANDIRI', 'nomor_rekening' => '823456789019', 'hari_kehadiran' => 26],
            ['nik' => '3201010101010009', 'nama' => 'INDAH SARI',        'no_hp' => '089934567898', 'bank' => 'BNI', 'nomor_rekening' => '923456789010', 'hari_kehadiran' => 30],
            ['nik' => '3201010101010010', 'nama' => 'JOKO SUSILO',       'no_hp' => '081034567899', 'bank' => 'BRI', 'nomor_rekening' => '023456789011', 'hari_kehadiran' => 24],
        ];

        foreach ($pesertaKelas1 as $data) {
            Peserta::create(array_merge($data, ['kelas_id' => $kelas1->id]));
        }

        $pesertaKelas2 = [
            ['nik' => '3201020101010011', 'nama' => 'KURNIAWAN HADI',    'no_hp' => '081111111111', 'bank' => 'BRI', 'nomor_rekening' => '111111111111', 'hari_kehadiran' => 28],
            ['nik' => '3201020101010012', 'nama' => 'LESTARI WULANDARI', 'no_hp' => '081222222222', 'bank' => 'BNI', 'nomor_rekening' => '222222222222', 'hari_kehadiran' => 28],
            ['nik' => '3201020101010013', 'nama' => 'MUHAMMAD RIZKI',    'no_hp' => '081333333333', 'bank' => 'BRI', 'nomor_rekening' => '333333333333', 'hari_kehadiran' => 20],
            ['nik' => '3201020101010014', 'nama' => 'NURUL HIDAYAH',     'no_hp' => '081444444444', 'bank' => 'MANDIRI', 'nomor_rekening' => '444444444444', 'hari_kehadiran' => 28],
            ['nik' => '3201020101010015', 'nama' => 'OKI SETIAWAN',      'no_hp' => '081555555555', 'bank' => 'BRI', 'nomor_rekening' => '555555555555', 'hari_kehadiran' => 28],
        ];

        foreach ($pesertaKelas2 as $data) {
            Peserta::create(array_merge($data, ['kelas_id' => $kelas2->id]));
        }

        $this->command->info('✅ Seeder berhasil: ' . Kejuruan::count() . ' kejuruan, '
            . Pelatihan::count() . ' pelatihan, '
            . Kelas::count() . ' kelas, '
            . Peserta::count() . ' peserta.');
    }
}