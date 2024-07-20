<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = Auth::check() ? Auth::user()->id : null;

        if ($userId) {
            $user = User::find($userId);
            $data = Guru::where('user_id', $user->id)->first();

            if ($user) {
                return view('pages.profile.index', compact('user', 'data'));
            } else {
                return redirect()->route('login')->with('error', 'User not found.');
            }
        } else {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required',
            'nama' => 'required',
            'new_password' => 'nullable|confirmed|min:8|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        try {
            $userId = Auth::check() ? Auth::user()->id : null;
            $user = User::find($userId);
            $data = Guru::where('user_id', $user->id)->first();

            if ($user->role == 1) {
                $user->update([
                    'username' => $request->nip,
                    'name' => $request->nama,
                ]);
            } else {
                // Update data diri
                $data->update([
                    'nip' => $request->nip,
                    'nama' => $request->nama,
                    'nohp' => $request->nohp,
                ]);

                $user->update([
                    'username' => $request->nip,
                    'name' => $request->nama,
                ]);
            }

            if ($request->filled('new_password')) {
                if (Hash::check($request->current_password, $user->password)) {
                    $user->update([
                        'password' => Hash::make($request->new_password)
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'errors' => ['current_password' => 'Password saat ini tidak valid.']
                    ]);
                }
            }

            $request->session()->flash('success', 'Data berhasil diperbarui');
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $th->getMessage()
            ]);
        }
    }
}
