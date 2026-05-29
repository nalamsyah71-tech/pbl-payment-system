<?php

namespace App\Livewire;

use App\Models\Kelas;
use App\Models\Peserta;
use Livewire\Component;

class FormUangSaku extends Component
{
    public $kelas_id = '';
    public $no_kuitansi = '';
    public $tgl_spby = '';
    public $pesertaList = [];
    public $detailPeserta = [];
    public $totalUang = 0;
    
    const TARIF_PER_HARI = 20000;

    public function mount()
    {
        $this->tgl_spby = date('Y-m-d');
    }

    public function updatedKelasId($value)
    {
        if (!$value) {
            $this->pesertaList = [];
            $this->detailPeserta = [];
            $this->totalUang = 0;
            return;
        }

        $pesertas = Peserta::where('kelas_id', $value)
            ->orderBy('nama')
            ->get(['id', 'nama', 'hari_kehadiran']);

        $this->pesertaList = $pesertas->toArray();
        
        $this->detailPeserta = [];
        foreach ($pesertas as $p) {
            $this->detailPeserta[] = [
                'id' => $p->id,
                'nama' => $p->nama,
                'hari_kehadiran' => $p->hari_kehadiran,
                'nominal' => $p->hari_kehadiran * self::TARIF_PER_HARI,
                'checked' => true,
            ];
        }

        $this->hitungTotal();
    }

    public function updateHariKehadiran($index, $value)
    {
        $hari = max(0, (int) $value);
        $this->detailPeserta[$index]['hari_kehadiran'] = $hari;
        $this->detailPeserta[$index]['nominal'] = $hari * self::TARIF_PER_HARI;
        $this->hitungTotal();
    }

    public function togglePeserta($index)
    {
        $this->detailPeserta[$index]['checked'] = !$this->detailPeserta[$index]['checked'];
        $this->hitungTotal();
    }

    public function hitungTotal()
    {
        $total = 0;
        foreach ($this->detailPeserta as $p) {
            if ($p['checked']) {
                $total += $p['nominal'];
            }
        }
        $this->totalUang = $total;
    }

    public function render()
    {
        $kelas = Kelas::with('pelatihan.kejuruan')->orderBy('nama_kelas')->get();
        return view('livewire.form-uang-saku', compact('kelas'));
    }
}