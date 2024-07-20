<?php

namespace App\Http\Controllers;

use App\Models\Crips;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $data['kriteria'] = Kriteria::all();

        return view('pages.kriteria.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            Kriteria::create([
                'name' => $request->name
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
            'data' => Kriteria::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {

        $data = Kriteria::find($id);

        $data->update([
            'name' => $request->edit_name,
        ]);

        $request->session()->flash('success', 'Data berhasil diperbarui');

        return response()->json([
            'status' => true,
            'message' => 'Berhasil diperbarui',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $data = Kriteria::findOrFail($id);

            if (Crips::where('kriteria_id', $data->id)->exists()) {
                $request->session()->flash('error', 'Tidak dapat menghapus data ini');
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus data kriteria',
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
