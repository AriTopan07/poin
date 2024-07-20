<?php

namespace App\Exports;

use App\Http\Repository\GlobalRepository;
use App\Http\Repository\SiswaRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class PelanggaranSiswaExport implements FromView
{
    use Exportable;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $report = new SiswaRepository();
        $data = $report->getPelanggaran($this->id);

        // dd($data);
        return view('exports.siswa-pelanggaran', [
            'data' => $data,
            'id' => $this->id,
        ]);
    }
}
