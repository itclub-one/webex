<?php

namespace App\Http\Controllers\frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TentangWebController extends Controller
{
    public function index(){
        return view('frontpage.tim.index');
    }
}
