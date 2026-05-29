<?php

namespace App\Livewire;

use App\Models\Kelas;
use App\Models\PembayaranAsuransi;
use Livewire\Component;

class FormAsuransi extends Component
{
    public $kelas_id = '';
    public $no_kuitansi = '';
    public $no_sk = '';
    public $tgl_spby = '';
    public $jumlahPeserta = 0;
    public $totalPremi = 0;
    
    const PREMI_PER_PESERTA = 8400;

    protected $rules = [
        'kelas_id' => 'required|exists:kelas,id',
        'no_kuitansi' => 'required|string|max:100',
        'tgl_spby' => 'required|date',
    ];

    public function mount()
    {
        $this->tgl_spby = date('Y-m-d');
    }

    public function updatedKelasId($value)
    {
        if (!$value) {
            $this->jumlahPeserta = 0;
            $this->totalPremi = 0;
            return;
        }

        $kelas = Kelas::withCount('pesertas')->find($value);
        $this->jumlahPeserta = $kelas ? $kelas->pesertas_count : 0;
        $this->hitungPremi();
    }

    public function hitungPremi()
    {
        $this->totalPremi = $this->jumlahPeserta * self::PREMI_PER_PESERTA;
    }

    public function simpan()
    {
        $this->validate();

        if ($this->jumlahPeserta < 1) {
            $this->addError('kelas_id', 'Kelas tidak memiliki peserta.');
            return;
        }

        PembayaranAsuransi::create([
            'kelas_id' => $this->kelas_id,
            'no_kuitansi' => $this->no_kuitansi,
            'no_sk' => $this->no_sk,
            'tgl_spby' => $this->tgl_spby,
            'jumlah_peserta' => $this->jumlahPeserta,
            'total_premi' => $this->totalPremi,
        ]);

        session()->flash('success', 'Pembayaran asuransi berhasil disimpan.');
        return redirect()->route('pembayaran-asuransi.index');
    }

    public function render()
    {
        $kelas = Kelas::with('pelatihan.kejuruan')->orderBy('nama_kelas')->get();
        return view('livewire.form-asuransi', compact('kelas'));
    }
}