<?php

namespace App\Http\Controllers;

use App\Http\Repository\SiswaRepository;
use App\Models\DetailPelanggaran;
use App\Models\DetailSiswa;
use App\Models\Kelas;
use App\Models\Sanksi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    protected $siswaRepository;

    public function __construct(SiswaRepository $siswa,)
    {
        $this->siswaRepository = $siswa;
    }

    public function index()
    {
        $data['kelas'] = Kelas::where('kelas', 'not like', '%alumni%')->get();

        return view('pages.siswa.index', compact('data'));
    }

    public function siswaByKelas($nama_kelas)
    {
        $nama_kelas = urldecode($nama_kelas);

        $kelas = Kelas::where('kelas', $nama_kelas)->firstOrFail();

        $data['kelas'] = $kelas;
        $data['siswa'] = $this->siswaRepository->getDataSiswaByKelas($nama_kelas);

        return view('pages.siswa.siswaByKelas', compact('data'));
    }

    public function siswaPoint($id)
    {
        $data['siswa'] = DB::table('siswas')
            ->select('siswas.*', 'detail_siswas.nama_siswa as siswa_nama', 'kelas.id as id_kelas')
            ->join('detail_siswas', 'siswas.id', '=', 'detail_siswas.siswa_id')
            ->join('kelas', 'kelas.id', '=', 'siswas.kelas_id')
            ->where('siswas.id', '=', $id)
            ->first();

        $data['kriteria'] = DB::table('kriterias')
            ->leftJoin('crips', 'crips.kriteria_id', '=', 'kriterias.id')
            ->select('kriterias.id', 'kriterias.name as kriteria_name', 'crips.id as crip_id', 'crips.name as crip_name')
            ->get();

        $kriteriaWithCrips = [];
        foreach ($data['kriteria'] as $item) {
            $kriteriaId = $item->id;
            if (!isset($kriteriaWithCrips[$kriteriaId])) {
                $kriteriaWithCrips[$kriteriaId] = (object) [
                    'id' => $kriteriaId,
                    'kriteria_name' => $item->kriteria_name,
                    'crips' => [],
                ];
            }
            if (!is_null($item->crip_id)) {
                $kriteriaWithCrips[$kriteriaId]->crips[] = (object) [
                    'id' => $item->crip_id,
                    'name' => $item->crip_name,
                ];
            }
        }

        $data['kriteria'] = array_values($kriteriaWithCrips);

        // Calculate total points of the student
        $data['pelanggaran'] = $this->siswaRepository->getPelanggaran($id);
        $data['total_points'] = $data['pelanggaran']->sum('crips_bobot');

        // Determine the appropriate sanksi based on total points
        $sanksi = Sanksi::where('bobot_dari', '<=', $data['total_points'])
            ->where('bobot_sampai', '>=', $data['total_points'])
            ->first();

        if ($sanksi) {
            // Insert into detail_pelanggarans table
            DetailPelanggaran::create([
                'siswa_id' => $id,
                'sanksi_id' => $sanksi->id,
                'total_bobot' => $data['total_points'],
            ]);

            $data['sanksi'] = $sanksi;
        } else {
            $data['sanksi'] = null;
        }

        return view('pages.pelanggaran.siswa', compact('data'));
    }

    public function create()
    {
        $data['kelas'] = Kelas::get();

        return view('pages.siswa.create', compact('data'));
    }

    public function show($id)
    {
        return response()->json([
            'status' => true,
            'message' => 'data siswa detail',
            'data' => $this->siswaRepository->showSiswa($id)
        ]);
    }

    public function edit($id)
    {
        $data['kelas'] = Kelas::get();
        $data['siswa'] = $this->siswaRepository->showSiswa($id);

        return view('pages.siswa.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $pesan = [
            'required' => ':attribute wajib diisi!',
            'numeric' => ':attribute harus diisi angka!',
        ];

        $validator = Validator::make($request->all(), [
            'kelas' => 'required',
            'nisn' => 'required|numeric',
            'nama_siswa' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'telp_siswa' => 'required|numeric',
            'alamat' => 'required',
            'nama_wali' => 'required',
            'telp_wali' => 'required|numeric',
            'status' => 'required',
            'alamat_wali' => 'required',
        ], $pesan);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        try {
            $siswa = Siswa::findOrFail($id);

            $siswa->update([
                'kelas_id' => $request->kelas,
            ]);

            $detailSiswa = DetailSiswa::where('siswa_id', $siswa->id)->firstOrFail();

            $detailSiswa->update([
                'nisn' => $request->nisn,
                'nama_siswa' => $request->nama_siswa,
                'telp_siswa' => $request->telp_siswa,
                'jk' => $request->jk,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nama_wali' => $request->nama_wali,
                'telp_wali' => $request->telp_wali,
                'status' => $request->status,
                'alamat_wali' => $request->alamat_wali,
            ]);

            $request->session()->flash('success', 'Data berhasil diperbarui');

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {

            $request->session()->flash('error', 'Terjadi kesalahan saat memperbarui data: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $th->getMessage()
            ]);
        }
    }


    public function store(Request $request)
    {
        $pesan = [
            'required' => ':attribute wajib diisi!',
            'numeric' => ':attribute harus diisi angka!',
        ];

        $validator = Validator::make($request->all(), [
            'kelas' => 'required',
            'nisn' => 'required|numeric',
            'nama_siswa' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'telp_siswa' => 'required|numeric',
            'alamat' => 'required',
            'nama_wali' => 'required',
            'telp_wali' => 'required|numeric',
            'status' => 'required',
            'alamat_wali' => 'required',
        ], $pesan);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        try {
            $siswa = Siswa::create([
                'kelas_id' => $request->kelas,
            ]);

            DetailSiswa::create([
                'siswa_id' => $siswa->id,
                'nisn' => $request->nisn,
                'nama_siswa' => $request->nama_siswa,
                'telp_siswa' => $request->telp_siswa,
                'jk' => $request->jk,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nama_wali' => $request->nama_wali,
                'telp_wali' => $request->telp_wali,
                'status' => $request->status,
                'alamat_wali' => $request->alamat_wali,
            ]);

            $request->session()->flash('success', 'Data berhasil ditambahkan');

            return response()->json([
                'success' => true,
                'message' => 'Berhasil tambah data'
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat menambahkan data: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan data: ' . $th->getMessage()
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $siswa = Siswa::findOrFail($id);

            $detailSiswa = DetailSiswa::where('siswa_id', $siswa->id)->firstOrFail();

            $detailSiswa->delete();

            $siswa->delete();

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
}
