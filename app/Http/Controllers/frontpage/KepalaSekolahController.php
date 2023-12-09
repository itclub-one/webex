<?php

namespace App\Http\Controllers\frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KepalaSekolahController extends Controller
{
    public function index(){
        return view('frontpage.kepala_sekolah.index');
    }
}
