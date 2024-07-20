<?php

namespace App\Http\Repository;

use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GlobalRepository
{
    public function getRiwayatGuru($user)
    {
        return DB::table('pelanggarans')
            ->select(
                'gurus.nama as nama_guru',
                'crips.name as crips_nama',
                'crips.bobot as crips_bobot',
                'detail_siswas.nama_siswa as nama_siswa',
                'kelas.kelas as kelas_nama',
                'kriterias.name as nama_kriteria',
                'pelanggarans.created_at as tgl',
                'pelanggarans.id as id',
            )
            ->join('siswas', 'pelanggarans.siswa_id', '=', 'siswas.id')
            ->join('detail_siswas', 'siswas.id', '=', 'detail_siswas.siswa_id')
            ->join('kelas', 'pelanggarans.kelas_id', '=', 'kelas.id')
            ->join('crips', 'pelanggarans.crips_id', '=', 'crips.id')
            ->join('kriterias', 'crips.kriteria_id', '=', 'kriterias.id')
            ->join('users', 'pelanggarans.user_id', '=', 'users.id')
            ->join('gurus', 'gurus.user_id', '=', 'users.id')
            ->where('pelanggarans.user_id', $user)
            ->orderBy('pelanggarans.created_at', 'desc')
            ->get();
    }

    public function getAllPelanggaran()
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
                'pelanggarans.created_at as tgl',
                'detail_siswas.*',
                'kelas.kelas as kelas_nama',
                'kriterias.name as nama_kriteria',
                'crips.name as crips_nama',
                'crips.bobot as crips_bobot',
                'users.name as user_nama',
                'detail_siswas.nama_siswa as nama_siswa'
            )
            ->where('pelanggarans.verified', '=', 1)
            ->orderBy('pelanggarans.created_at', 'desc')
            ->get();
    }

    public function getPelanggaranNotVerified()
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
                'pelanggarans.created_at as tgl',
                'pelanggarans.id as id_pel',
                'detail_siswas.*',
                'kelas.kelas as kelas_nama',
                'kriterias.name as nama_kriteria',
                'crips.name as crips_nama',
                'crips.bobot as crips_bobot',
                'users.name as user_nama',
                'detail_siswas.nama_siswa as nama_siswa'
            )
            ->where('pelanggarans.verified', '=', 0)
            ->orderBy('pelanggarans.created_at', 'desc')
            ->get();
    }

    public function chart()
    {
        return DB::table('pelanggarans')
            ->join('kelas', 'pelanggarans.kelas_id', '=', 'kelas.id')
            ->select(DB::raw('count(pelanggarans.id) as total_violations'), 'kelas.name')
            ->groupBy('kelas.name')
            ->get();
    }

    public function getPelanggaranByTahun($tahun)
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
                DB::raw('DATE(pelanggarans.created_at) as tgl'),
                'detail_siswas.*',
                'kelas.kelas as kelas_nama',
                'kriterias.name as nama_kriteria',
                'crips.name as crips_nama',
                'crips.bobot as crips_bobot',
                'users.name as user_nama',
            )
            ->whereYear('pelanggarans.created_at', $tahun)
            ->where('pelanggarans.verified', '=', 1)
            ->orderBy('pelanggarans.created_at', 'desc')
            ->get();
    }

    public function sendNotification($wa_wali, $student_name, $kelas_name, $violations)
    {
        $curl = curl_init();
        $token = 'kcWqz1dpbNoL73zD5wxv';

        $message = "*Pemberitahuan*\n\n";
        $message .= "kepada Yth Bapak/Ibu Wali Murid\n\n";
        $message .= "Nama Siswa : $student_name\n";
        $message .= "Kelas : $kelas_name\n";
        $message .= "Telah melakukan pelanggaran\n";
        $message .= "Deskripsi Pelanggaran :\n";

        // Append each violation description
        foreach ($violations as $violation) {
            $message .= "- Pelanggaran ({$violation->criteria_name}) - {$violation->violation_name}\n";
        }

        $message .= "\nMohon untuk memperhatikan dan menasihati kembali siswa siswi Bapak/Ibu sekalian";
        $message .= "\nTerima Kasih";
        $message .= "\n\nHormat Kami";
        $message .= "\n\nBK";

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'target' => $wa_wali,
                'message' => $message,
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
