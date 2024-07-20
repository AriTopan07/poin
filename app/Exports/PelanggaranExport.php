<?php

namespace App\Exports;

use App\Http\Repository\GlobalRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class PelanggaranExport implements FromView
{
    use Exportable;

    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $report = new GlobalRepository();
        $data = $report->getPelanggaranByTahun($this->tahun);

        // dd($data);
        return view('exports.pelanggaran', [
            'data' => $data,
            'tahun' => $this->tahun,
        ]);
    }
}
