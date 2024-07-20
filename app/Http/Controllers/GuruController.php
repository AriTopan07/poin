<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $data['guru'] = Guru::all();

        return view('pages.guru.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nip' => 'required|numeric',
                'nama' => 'required|string|max:255',
                'nohp' => 'required|string|max:20'
            ]);

            $user = User::create([
                'name' => $request->nama,
                'username' => $request->nip,
                'role' => 2,
                'password' => Hash::make($request->nip),
            ]);

            $guru = Guru::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'nama' => $request->nama,
                'nohp' => $request->nohp,
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat validasi data ' . $th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $guru = Guru::findOrFail($id);

            $user = User::findOrFail($guru->user_id);

            $guru->delete();

            $user->delete();

            $request->session()->flash('success', 'Data berhasil dihapus');

            return response()->json([
                'status' => true,
                'data' => $guru,
                'message' => 'Berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            $request->session()->flash('error', 'Terjadi kesalahan saat menghapus data ' . $th->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal dihapus'
            ], 500);
        }
    }
}
