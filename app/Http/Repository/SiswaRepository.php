<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SiswaRepository
{
    public function getDataSiswaByKelas($nama_kelas)
    {
        $kelas = Kelas::where('kelas', $nama_kelas)->firstOrFail();
        $data = DB::table('siswas')
            ->select('siswas.*', 'detail_siswas.*', 'kelas.kelas')
            ->join('detail_siswas', 'siswas.id', '=', 'detail_siswas.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'siswas.kelas_id')
            ->where('siswas.kelas_id', '=', $kelas->id)
            ->get();

        return $data;
    }

    public function getPelanggaran($id)
    {
        return DB::table('pelanggarans')
            ->join('siswas', 'pelanggarans.siswa_id', '=', 'siswas.id')
            ->join('detail_siswas', 'siswas.id', '=', 'detail_siswas.siswa_id')
            ->join('kelas', 'pelanggarans.kelas_id', '=', 'kelas.id')
            ->join('crips', 'pelanggarans.crips_id', '=', 'crips.id')
            ->join('kriterias', 'crips.kriteria_id', '=', 'kriterias.id')
            ->join('users', 'pelanggarans.user_id', '=', 'users.id')
            ->select(
                'pelanggarans.*',
                'pelanggarans.id as pel_id',
                'pelanggarans.created_at as tgl',
                'detail_siswas.*',
                'kelas.kelas as kelas_nama',
                'kriterias.name as nama_kriteria',
                'crips.name as crips_nama',
                'crips.bobot as crips_bobot',
                'users.name as user_nama',
                'detail_siswas.id as siswa_id',
            )
            ->where('pelanggarans.siswa_id', '=', $id)
            ->orderBy('pelanggarans.created_at', 'desc')
            ->get();
    }

    public function showSiswa($id)
    {
        return DB::table('siswas')
            ->select('detail_siswas.*', 'siswas.*')
            ->join('detail_siswas', 'siswas.id', '=', 'detail_siswas.siswa_id')
            ->where('siswas.id', '=', $id)
            ->first();
    }
}
