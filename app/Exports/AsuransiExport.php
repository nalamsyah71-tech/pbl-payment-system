<?php

namespace App\Exports;

use App\Models\PembayaranAsuransi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class AsuransiExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithCustomStartCell, WithEvents
{
    protected PembayaranAsuransi $pembayaran;

    public function __construct(PembayaranAsuransi $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function collection(): Collection
    {
        $pesertas = $this->pembayaran->kelas->pesertas;
        return $pesertas->map(fn($p, $i) => [
            'no'    => $i + 1,
            'nik'   => $p->nik,
            'nama'  => $p->nama,
            'premi' => \App\Models\PembayaranAsuransi::PREMI_PER_PESERTA,
        ]);
    }

    public function headings(): array
    {
        return ['NO', 'NIK', 'NAMA PESERTA', 'PREMI (Rp)'];
    }

    public function title(): string
    {
        return 'Daftar Penerima Asuransi';
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function styles(Worksheet $sheet): array
    {
        $kelas = $this->pembayaran->kelas;

        $sheet->setCellValue('A1', 'DAFTAR PENERIMA ASURANSI BPJS KETENAGAKERJAAN');
        $sheet->setCellValue('A2', 'Pelatihan : ' . $kelas->pelatihan->nama);
        $sheet->setCellValue('A3', 'Kelas     : ' . $kelas->nama_kelas);
        $sheet->setCellValue('A4', 'No Kuitansi: ' . $this->pembayaran->no_kuitansi
            . '   Tanggal: ' . $this->pembayaran->tgl_spby->format('d/m/Y'));

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            5 => ['font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
                  'fill' => ['fillType' => Fill::FILL_SOLID,
                             'startColor' => ['rgb' => '1e3a5f']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet   = $event->sheet->getDelegate();
                $count   = $this->pembayaran->kelas->pesertas->count();
                $lastRow = $count + 5;

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(35);
                $sheet->getColumnDimension('D')->setWidth(18);

                $sheet->getStyle('D6:D' . $lastRow)
                    ->getNumberFormat()->setFormatCode('#,##0');

                $sheet->getStyle('A5:D' . $lastRow)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Total baris
                $totalRow = $lastRow + 1;
                $sheet->setCellValue('C' . $totalRow, 'TOTAL PREMI');
                $sheet->setCellValue('D' . $totalRow, $this->pembayaran->total_premi);
                $sheet->getStyle('C' . $totalRow . ':D' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('D' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');

                $sheet->mergeCells('A1:D1');
                $sheet->getStyle('A1')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}