<?php

namespace App\Http\Controllers;

use App\Http\Repository\GlobalRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    protected $globalRepository;

    public function __construct(GlobalRepository $globalRepository)
    {
        $this->globalRepository = $globalRepository;
    }

    public function index()
    {
        $user = Auth::check() ? Auth::user()->id : null;

        $data['riwayat'] = $this->globalRepository->getRiwayatGuru($user);

        return view('pages.riwayat.index', compact('data'));
    }
}
