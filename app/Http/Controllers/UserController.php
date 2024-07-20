<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 1) {
            $data['user'] = User::all();

            return view('pages.user.index', compact('data'));
        } else {
            return view('404');
        }
    }
}
