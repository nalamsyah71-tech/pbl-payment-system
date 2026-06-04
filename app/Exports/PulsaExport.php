<?php

namespace App\Exports;

use App\Models\PembayaranPulsa;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PulsaExport implements FromArray, WithHeadings, WithTitle
{
    protected $pembayaran;

    public function __construct(PembayaranPulsa $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function array(): array
    {
        $detail = $this->pembayaran->detail_peserta;
        
        if (is_string($detail)) {
            $detail = json_decode($detail, true);
        }
        
        if (!is_array($detail)) {
            $detail = [];
        }
        
        $data = [];
        foreach ($detail as $index => $item) {
            $data[] = [
                $index + 1,
                $item['nama'] ?? '-',
                $item['no_hp'] ?? '-',
                $item['nominal'] ?? 0,
            ];
        }
        
        return $data;
    }

    public function headings(): array
    {
        $kelas = $this->pembayaran->kelas;
        
        return [
            ['DAFTAR PENERIMA BANTUAN PULSA INTERNET'],
            ['Pelatihan : ' . ($kelas->pelatihan->nama ?? '-')],
            ['Kelas : ' . ($kelas->nama_kelas ?? '-')],
            ['No Kuitansi: ' . $this->pembayaran->no_kuitansi . '   Tanggal: ' . $this->pembayaran->tgl_spby->format('d/m/Y')],
            ['NO', 'NAMA PESERTA', 'NOMOR HP', 'NOMINAL (Rp)'],
        ];
    }

    public function title(): string
    {
        return 'Daftar Penerima Pulsa';
    }
}