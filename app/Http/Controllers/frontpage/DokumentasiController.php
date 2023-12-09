<?php

namespace App\Http\Controllers\frontpage;

use App\Models\admin\Eskul;
use Illuminate\Http\Request;
use App\Models\admin\Dokumentasi;
use App\Http\Controllers\Controller;

class DokumentasiController extends Controller
{
    public function index(){
        $data = Dokumentasi::with('eskul.eskul_detail')->paginate(12);

        return view('frontpage.dokumentasi.index', compact(
            'data',
        ));
    }
    
    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $data = Dokumentasi::with('eskul.eskul_detail')->paginate(12);
            return view('frontpage.dokumentasi.fetch_data.dokumentasi', compact('data'))->render();
        }
    }
    
    public function showByEskul($eskul){
        $data_eskul = Eskul::where('slug', $eskul)->first();
        if (!$data_eskul) {
            abort(404);
        }
        $data = Dokumentasi::where('eskul_id', $data_eskul->id)->with('eskul.eskul_detail')->paginate(12);
    
        return view('frontpage.dokumentasi.showByEskul', compact('data','data_eskul'));
    }
    
    public function showByEskulAndSlug($eskul,$slug){
        $data_eskul = Eskul::where('slug', $eskul)->first();
        if (!$data_eskul) {
            abort(404);
        }
        $data = Dokumentasi::where('eskul_id', $data_eskul->id)->where('slug', $slug)->with('eskul.eskul_detail')->first();
        if (!$data) {
            abort(404);
        }
    
        return view('frontpage.dokumentasi.showBySlug', compact('data','data_eskul'));
    }
    
}
