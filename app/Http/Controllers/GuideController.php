<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function index() {
        return view('anggota.guide');
    }
}
