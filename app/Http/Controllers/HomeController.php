<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $data['cart'] = DB::table('pelanggarans')
            ->join('kelas', 'pelanggarans.kelas_id', '=', 'kelas.id')
            ->select(DB::raw('count(pelanggarans.id) as total_violations'), 'kelas.kelas')
            ->where('pelanggarans.verified', '=', 1)
            ->groupBy('kelas.kelas')
            ->get();

        // dd($data);

        return view('home', compact('data'));
    }
}
