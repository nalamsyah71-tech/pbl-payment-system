<?php

namespace App\Exports;

use App\Models\PembayaranUangSaku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Collection;

class UangSakuExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithCustomStartCell, WithEvents
{
    protected $pembayaran;

    public function __construct(PembayaranUangSaku $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function collection(): Collection
    {
        $detail = $this->pembayaran->detail_peserta;
        
        // Jika masih string JSON, decode dulu
        if (is_string($detail)) {
            $detail = json_decode($detail, true);
        }
        
        // Jika null atau bukan array, set default
        if (!is_array($detail)) {
            $detail = [];
        }
        
        return collect($detail)->map(function ($item, $index) {
            return [
                'no'             => $index + 1,
                'nama'           => $item['nama'] ?? '-',
                'hari_kehadiran' => $item['hari_kehadiran'] ?? 0,
                'tarif'          => PembayaranUangSaku::TARIF_PER_HARI ?? 20000,
                'nominal'        => $item['nominal'] ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return ['NO', 'NAMA PESERTA', 'HARI HADIR', 'TARIF/HARI (Rp)', 'TOTAL (Rp)'];
    }

    public function title(): string
    {
        return 'Daftar Penerima Uang Saku';
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function styles(Worksheet $sheet): array
    {
        $kelas = $this->pembayaran->kelas;
        $pelatihan = $kelas->pelatihan;

        $sheet->setCellValue('A1', 'DAFTAR PENERIMA UANG SAKU');
        $sheet->setCellValue('A2', 'Pelatihan : ' . ($pelatihan->nama ?? '-'));
        $sheet->setCellValue('A3', 'Kelas     : ' . ($kelas->nama_kelas ?? '-'));
        $sheet->setCellValue('A4', 'No Kuitansi: ' . $this->pembayaran->no_kuitansi
            . '   Tanggal: ' . $this->pembayaran->tgl_spby->format('d/m/Y'));

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 14]
            ],
            5 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1e3a5f']
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $detail = $this->pembayaran->detail_peserta;
                if (is_string($detail)) {
                    $detail = json_decode($detail, true);
                }
                
                $lastRow = 5;
                if (is_array($detail)) {
                    $lastRow = count($detail) + 5;
                }
                
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(35);
                $sheet->getColumnDimension('C')->setWidth(12);
                $sheet->getColumnDimension('D')->setWidth(18);
                $sheet->getColumnDimension('E')->setWidth(18);
                
                if ($lastRow >= 6) {
                    $sheet->getStyle('E6:E' . $lastRow)
                        ->getNumberFormat()
                        ->setFormatCode('#,##0');
                }
                
                $sheet->getStyle('A5:E5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E0E0E0']
                    ]
                ]);
            },
        ];
    }
}