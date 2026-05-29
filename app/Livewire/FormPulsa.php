<?php

namespace App\Livewire;

use App\Models\Kelas;
use App\Models\Peserta;
use Livewire\Component;
use Livewire\Attributes\Layout;

class FormPulsa extends Component
{
    public $kelas_id = '';
    public $no_kuitansi = '';
    public $no_sk = '';
    public $tgl_spby = '';
    public $pesertaList = [];
    public $detailPeserta = [];
    public $totalUang = 0;
    public $nominalPerPeserta = 50000;

    public function mount(): void
    {
        $this->tgl_spby = now()->format('Y-m-d');
    }

    public function updatedKelasId($value): void
    {
        if (!$value) {
            $this->pesertaList = [];
            $this->detailPeserta = [];
            $this->totalUang = 0;
            return;
        }

        $pesertas = Peserta::where('kelas_id', $value)
            ->orderBy('nama')
            ->get(['id', 'nama', 'no_hp']);

        $this->pesertaList = $pesertas->toArray();
        $this->detailPeserta = $pesertas->map(function($p) {
            return [
                'id' => $p->id,
                'nama' => $p->nama,
                'no_hp' => $p->no_hp,
                'nominal' => $this->nominalPerPeserta,
                'checked' => true,
            ];
        })->toArray();

        $this->hitungTotal();
    }

    public function updateNominal($index, $value): void
    {
        $this->detailPeserta[$index]['nominal'] = (int) $value;
        $this->hitungTotal();
    }

    public function togglePeserta($index): void
    {
        $this->detailPeserta[$index]['checked'] = !$this->detailPeserta[$index]['checked'];
        $this->hitungTotal();
    }

    public function hitungTotal(): void
    {
        $this->totalUang = collect($this->detailPeserta)
            ->where('checked', true)
            ->sum('nominal');
    }

    public function setNominalSama(): void
    {
        foreach ($this->detailPeserta as $i => $p) {
            $this->detailPeserta[$i]['nominal'] = $this->nominalPerPeserta;
        }
        $this->hitungTotal();
    }

    public function render()
    {
        $kelas = Kelas::with('pelatihan.kejuruan')->orderBy('nama_kelas')->get();
        return view('livewire.form-pulsa', compact('kelas'));
    }
}