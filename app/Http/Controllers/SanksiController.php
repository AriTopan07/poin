<?php

namespace App\Http\Controllers;

use App\Models\DetailPelanggaran;
use App\Models\Sanksi;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index()
    {
        $data['sanksi'] = Sanksi::all();

        return view('pages.sanksi.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'sanksi' => 'required',
                'bobot_dari' => 'required',
                'bobot_sampai' => 'required',
                'keterangan' => 'required',
            ]);

            Sanksi::create([
                'sanksi' => $request->sanksi,
                'bobot_dari' => $request->bobot_dari,
                'bobot_sampai' => $request->bobot_sampai,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());
        }
    }

    public function show($id)
    {
        return response()->json([
            'status' => true,
            'message' => 'data',
            'data' => Sanksi::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'edit_sanksi' => 'required',
                'edit_bobot_dari' => 'required',
                'edit_bobot_sampai' => 'required',
                'edit_keterangan' => 'required',
            ]);

            $data = Sanksi::findOrFail($id);

            $data->update([
                'sanksi' => $request->edit_sanksi,
                'bobot_dari' =>  $request->edit_bobot_dari,
                'bobot_sampai' =>  $request->edit_bobot_sampai,
                'keterangan' =>  $request->edit_keterangan,
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
            $data = Sanksi::findOrFail($id);

            if (DetailPelanggaran::where('sanksi_id', $data->id)->exists()) {
                $request->session()->flash('error', 'Tidak dapat menghapus data ini');
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus data',
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
                'message' => 'Gagal.',
            ]);
        }
    }
}
