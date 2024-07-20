<?php

namespace App\Http\Controllers;

use App\Http\Repository\GlobalRepository;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelanggaranController extends Controller
{
    protected $globalRepository;

    public function __construct(GlobalRepository $globalRepository)
    {
        $this->globalRepository = $globalRepository;
    }

    public function index()
    {
        $data['all'] = $this->globalRepository->getAllPelanggaran();
        $data['notVerified'] = $this->globalRepository->getPelanggaranNotVerified();
        $data['count'] = Pelanggaran::where('verified', '=', 0)->count();

        return view('pages.pelanggaran.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $kelas_id = $request->input('kelas_id');
            $siswa_id = $request->input('siswa_id');
            $crips_ids = $request->input('crips_id', []);

            foreach ($crips_ids as $crips_id) {
                DB::table('pelanggarans')->insert([
                    'kelas_id' => $kelas_id,
                    'siswa_id' => $siswa_id,
                    'crips_id' => $crips_id,
                    'user_id' => $user_id,
                    'verified' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $request->session()->flash('success', 'Berhasil input pelanggaran siswa');

            return response()->json([
                'success' => true,
                'message' => 'Data successfully stored.'
            ]);
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function verif(Request $request, $id)
    {
        try {
            $pelanggaran = Pelanggaran::findOrFail($id);
            $pelanggaran->verified = 1;
            $pelanggaran->save();

            // Retrieve necessary data for the notification
            $student = DB::table('siswas')
                ->join('detail_siswas', 'siswas.id', '=', 'detail_siswas.siswa_id')
                ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
                ->where('detail_siswas.siswa_id', $pelanggaran->siswa_id)
                ->select(
                    'detail_siswas.telp_wali as whatsapp',
                    'detail_siswas.nama_siswa as student_name',
                    'kelas.kelas as kelas_name'
                )
                ->first();

            $violations = DB::table('pelanggarans')
                ->join('crips', 'pelanggarans.crips_id', '=', 'crips.id')
                ->join('kriterias', 'crips.kriteria_id', '=', 'kriterias.id')
                ->where('pelanggarans.id', $pelanggaran->id)
                ->where('pelanggarans.siswa_id', $pelanggaran->siswa_id)
                ->where('pelanggarans.kelas_id', $pelanggaran->kelas_id)
                ->select('crips.name as violation_name', 'kriterias.name as criteria_name')
                ->get();

            // Send WhatsApp notification
            if ($student && $student->whatsapp && $student->kelas_name) {
                $this->globalRepository->sendNotification($student->whatsapp, $student->student_name, $student->kelas_name, $violations);
            }

            $request->session()->flash('success', 'Data terverifikasi dan berhasil mengirim notifikasi ke wali murid');
            return response()->json([
                'success' => true,
                'message' => 'Data successfully verified and notification sent.'
            ]);
        } catch (\Throwable $e) {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function Tolak(Request $request, $id)
    {
        try {
            $pelanggaran = Pelanggaran::findOrFail($id);
            $pelanggaran->delete();

            $request->session()->flash('success', 'Data pelanggaran ditolak');
            return response()->json([
                'success' => true,
                'message' => 'Data successfully rejected.'
            ]);
        } catch (\Throwable $e) {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $data = Pelanggaran::findOrFail($id);

            $data->delete();

            $request->session()->flash('success', 'Data berhasil dihapus');

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat menghapus data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $th->getMessage()
            ]);
        }
    }

    public function storetes(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $kelas_id = $request->input('kelas_id');
            $siswa_id = $request->input('siswa_id');
            $crips_ids = $request->input('crips_id', []);

            $violations = [];

            foreach ($crips_ids as $crips_id) {
                DB::table('pelanggarans')->insert([
                    'kelas_id' => $kelas_id,
                    'siswa_id' => $siswa_id,
                    'crips_id' => $crips_id,
                    'user_id' => $user_id,
                    'verified' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $violation = DB::table('crips')
                    ->join('kriterias', 'crips.kriteria_id', '=', 'kriterias.id')
                    ->where('crips.id', $crips_id)
                    ->select('crips.name as violation_name', 'kriterias.name as criteria_name')
                    ->first();

                if ($violation) {
                    $violations[] = $violation;
                }
            }

            $student = DB::table('siswas')
                ->join('detail_siswas', 'siswas.id', '=', 'detail_siswas.siswa_id')
                ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
                ->where('detail_siswas.siswa_id', $siswa_id)
                ->select(
                    'detail_siswas.telp_wali as whatsapp',
                    'detail_siswas.nama_siswa as student_name',
                    'kelas.kelas as kelas_name'
                )
                ->first();

            // Send WhatsApp notification
            if ($student && $student->whatsapp && $student->kelas_name) {
                $this->globalRepository->sendNotification($student->whatsapp, $student->student_name, $student->kelas_name, $violations);
            }

            $request->session()->flash('success', 'Berhasil input pelanggaran siswa');

            return response()->json([
                'success' => true,
                'message' => 'Data successfully stored.'
            ]);
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
