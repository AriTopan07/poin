<?php

namespace App\Http\Controllers;

use App\Models\Crips;
use App\Models\Kriteria;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CripsController extends Controller
{
    public function index()
    {
        $data['kriteria'] = Kriteria::get();
        $data['crips'] = Crips::orderBy('bobot', 'DESC')->get();

        return view('pages.bobot.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $data = Validator::make($request->all(), [
                'kriteria_id' => 'required|exists:kriterias,id',
                'name' => 'required',
                'bobot' => 'required'
            ]);

            $data = Crips::create($request->all());

            $request->session()->flash('success', 'Data berhasil ditambahkan');

            return response()->json([
                'status' => true,
                'data' => $data,
                'message' => 'Berhasil ditambahkan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json([
            'status' => true,
            'message' => 'Detail data',
            'data' => $crips = Crips::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {

        $crips = Crips::find($id);

        $crips->update($request->all());

        $request->session()->flash('success', 'Data berhasil diperbarui');

        return response()->json([
            'status' => true,
            'message' => 'Berhasil diperbarui',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $data = Crips::find($id);

        $data->delete();

        $request->session()->flash('success', 'Data berhasil dihapus');

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil dihapus'
        ]);
    }
}
