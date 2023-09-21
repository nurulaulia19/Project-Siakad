<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class NilaiExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $dataKn;
    protected $dataGp;
    protected $dataSekolah;
    protected $tab;
    protected $dataKk;

    public function __construct($dataKn, $dataGp, $dataSekolah, $tab, $dataKk)
    {
        $this->dataKn = $dataKn;
        $this->dataGp = $dataGp;
        $this->dataSekolah = $dataSekolah;
        $this->tab = $tab;
        $this->dataKk = $dataKk;
    }

    public function view(): View
    {
        return view('dataNilai.eksportNilai', [
            'dataKn' => $this->dataKn,
            'dataGp' => $this->dataGp,
            'dataSekolah' => $this->dataSekolah,
            'tab' => $this->tab,
            'dataKk' => $this->dataKk,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Ambil jumlah baris data
        $rowCount = count($this->dataKk) + 2; // Sesuaikan jumlah baris dengan data yang akan Anda tampilkan

        // Berikan border ke seluruh kolom dan baris yang berisi data
        $sheet->getStyle('A2:D' . $rowCount)->getBorders()->getAllBorders()->setBorderStyle('thin');
    }

}
