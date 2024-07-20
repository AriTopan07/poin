<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $data['kelas'] = Kelas::all();

        return view('pages.kelas.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required'
        ]);

        Kelas::create([
            'kelas' => $request->kelas
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $data = Kelas::where('id', $id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'edit_kelas' => 'required|string',
            ]);

            $data = Kelas::findOrFail($id);

            $data->update([
                'kelas' => $request->edit_kelas,
            ]);

            $request->session()->flash('success', 'Data berhasil diperbarui');

            return response()->json([
                'status' => true,
                'message' => 'berhasil diperbarui.',
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal diperbarui.',
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = Kelas::findOrFail($id);

            if (Siswa::where('kelas_id', $data->id)->exists()) {
                $request->session()->flash('error', 'Tidak dapat menghapus data ini');
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus data kelas',
                ]);
            } else {
                $data->delete();

                $request->session()->flash('success', 'Data Berhasil dihapus');
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil dihapus'
                ]);
            }
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal diperbarui.',
            ]);
        }
    }
}
