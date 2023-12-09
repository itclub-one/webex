<?php

namespace App\Http\Controllers\frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WakilKepalaSekolahController extends Controller
{
    public function index(){
        return view('frontpage.wakil_kepala_sekolah.index');
    }
}
