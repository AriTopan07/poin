<?php

namespace App\Http\Controllers;

use App\Exports\PelanggaranExport;
use App\Exports\PelanggaranSiswaExport;
use App\Http\Repository\GlobalRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function download_excel(Request $request)
    {
        $tahun = $request->tahun;

        return $this->pelanggaran($tahun);
    }

    public function download_siswa(Request $request)
    {
        $id = $request->id;

        return $this->pelanggaranSiswa($id);
    }

    public function pelanggaranSiswa($id)
    {
        return Excel::download(new PelanggaranSiswaExport($id), 'pelanggaran-siswa.xlsx');
    }

    public function pelanggaran($tahun)
    {
        $data = new GlobalRepository();
        $get = $data->getPelanggaranByTahun($tahun);
        if ($get->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data pelanggaran untuk tahun ' . $tahun);
        }
        return Excel::download(new PelanggaranExport($tahun), 'pelanggaran.xlsx');
    }
}
