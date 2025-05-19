<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get(); // hanya user biasa
        return view('admin.index', compact('users'));
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        $results = Result::with('passion')->where('user_id', $id)->get();

        return view('admin.show', compact('user', 'results'));
    }
}
