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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class UangSakuExport implements FromCollection, WithHeadings, WithTitle, WithStyles, WithCustomStartCell, WithEvents
{
    protected PembayaranUangSaku $pembayaran;

    public function __construct(PembayaranUangSaku $pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function collection(): Collection
    {
        $detail = collect($this->pembayaran->detail_peserta);
        return $detail->map(fn($item, $index) => [
            'no'             => $index + 1,
            'nama'           => $item['nama'],
            'hari_kehadiran' => $item['hari_kehadiran'],
            'tarif'          => \App\Models\PembayaranUangSaku::TARIF_PER_HARI,
            'nominal'        => $item['nominal'],
        ]);
    }

    public function headings(): array
    {
        return ['NO', 'NAMA PESERTA', 'HARI HADIR', 'TARIF/HARI (Rp)', 'TOTAL (Rp)'];
    }

    public function title(): string
    {
        return 'Rekapitulasi Uang Saku';
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function styles(Worksheet $sheet): array
    {
        $kelas = $this->pembayaran->kelas;

        $sheet->setCellValue('A1', 'REKAPITULASI PEMBAYARAN UANG SAKU HARIAN');
        $sheet->setCellValue('A2', 'Pelatihan   : ' . $kelas->pelatihan->nama);
        $sheet->setCellValue('A3', 'Kelas       : ' . $kelas->nama_kelas);
        $sheet->setCellValue('A4', 'Periode     : '
            . $kelas->tgl_mulai->format('d/m/Y') . ' s/d '
            . $kelas->tgl_selesai->format('d/m/Y'));
        $sheet->setCellValue('A5', 'No Kuitansi : ' . $this->pembayaran->no_kuitansi
            . '   Tanggal: ' . $this->pembayaran->tgl_spby->format('d/m/Y'));

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            6 => ['font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
                  'fill' => ['fillType' => Fill::FILL_SOLID,
                             'startColor' => ['rgb' => '1e3a5f']]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet   = $event->sheet->getDelegate();
                $count   = count($this->pembayaran->detail_peserta);
                $lastRow = $count + 6;

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(35);
                $sheet->getColumnDimension('C')->setWidth(14);
                $sheet->getColumnDimension('D')->setWidth(18);
                $sheet->getColumnDimension('E')->setWidth(18);

                $sheet->getStyle('D7:E' . $lastRow)
                    ->getNumberFormat()->setFormatCode('#,##0');

                $sheet->getStyle('A6:E' . $lastRow)
                    ->getBorders()->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $totalRow = $lastRow + 1;
                $sheet->setCellValue('D' . $totalRow, 'TOTAL');
                $sheet->setCellValue('E' . $totalRow, $this->pembayaran->total_uang);
                $sheet->getStyle('D' . $totalRow . ':E' . $totalRow)->getFont()->setBold(true);
                $sheet->getStyle('E' . $totalRow)->getNumberFormat()->setFormatCode('#,##0');

                $sheet->mergeCells('A1:E1');
                $sheet->getStyle('A1')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}