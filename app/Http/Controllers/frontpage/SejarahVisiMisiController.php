<?php

namespace App\Http\Controllers\frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SejarahVisiMisiController extends Controller
{
    public function index(){
        return view('frontpage.visi_misi_smk.index');
    }
}
