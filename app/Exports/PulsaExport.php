<?php

namespace App\Exports;

use App\Models\PembayaranPulsa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Collection;

class PulsaExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithCustomStartCell, WithEvents
{
    protected PembayaranPulsa $pembayaran;

    public function __construct(PembayaranPulsa $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function collection(): Collection
    {
        $detail = collect($this->pembayaran->detail_peserta);
        return $detail->map(fn($item, $index) => [
            'no'      => $index + 1,
            'nama'    => $item['nama'],
            'no_hp'   => $item['no_hp'],
            'nominal' => $item['nominal'],
        ]);
    }

    public function headings(): array
    {
        return ['NO', 'NAMA PESERTA', 'NOMOR HP', 'NOMINAL (Rp)'];
    }

    public function title(): string
    {
        return 'Daftar Penerima Pulsa';
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function styles(Worksheet $sheet): array
    {
        $kelas     = $this->pembayaran->kelas;
        $pelatihan = $kelas->pelatihan;

        $sheet->setCellValue('A1', 'DAFTAR PENERIMA BANTUAN PULSA INTERNET');
        $sheet->setCellValue('A2', 'Pelatihan : ' . $pelatihan->nama);
        $sheet->setCellValue('A3', 'Kelas     : ' . $kelas->nama_kelas);
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
                $sheet     = $event->sheet->getDelegate();
                $lastRow   = count($this->pembayaran->detail_peserta) + 5;

                // Auto-fit kolom
                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(35);
                $sheet->getColumnDimension('C')->setWidth(20);
                $sheet->getColumnDimension('D')->setWidth(20);

                // Format nominal sebagai currency
                $sheet->getStyle('D6:D' . $lastRow)
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Border seluruh tabel
                $sheet->getStyle('A5:D' . $lastRow)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Row total
                $totalRow = $lastRow + 1;
                $sheet->setCellValue('C' . $totalRow, 'TOTAL');
                $sheet->setCellValue('D' . $totalRow, $this->pembayaran->total_uang);
                $sheet->getStyle('C' . $totalRow . ':D' . $totalRow)
                    ->getFont()->setBold(true);
                $sheet->getStyle('D' . $totalRow)
                    ->getNumberFormat()->setFormatCode('#,##0');

                // Merge header
                $sheet->mergeCells('A1:D1');
                $sheet->getStyle('A1')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}