<?php

namespace App\Http\Controllers\frontpage;

use App\Models\admin\Eskul;
use App\Models\admin\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    public function index(){
        $data = berita::with('eskul.eskul_detail')->orderBy('created_at', 'DESC')->paginate(9);
        $berita_terbaru = Berita::with('eskul.eskul_detail')->orderBy('created_at', 'DESC')->limit(1)->first();
        $berita_terbaru2 = Berita::with('eskul.eskul_detail')->orderBy('created_at', 'DESC')->skip(1)->take(2)->get();

        return view('frontpage.berita.index', compact(
            'data',
            'berita_terbaru',
            'berita_terbaru2'
        ));
    }
    
    public function showByEskul($eskul){
        $data_eskul = Eskul::where('slug', $eskul)->first();
        if (!$data_eskul) {
            abort(404);
        }
        $data = berita::where('eskul_id', $data_eskul->id)->with('eskul.eskul_detail')->orderBy('created_at', 'DESC')->paginate(9);
        $berita_terbaru = Berita::where('eskul_id', $data_eskul->id)->with('eskul.eskul_detail')->orderBy('created_at', 'DESC')->limit(1)->first();
        $berita_terbaru2 = Berita::where('eskul_id', $data_eskul->id)->with('eskul.eskul_detail')->orderBy('created_at', 'DESC')->skip(1)->take(2)->get();

        return view('frontpage.berita.showByEskul', compact(
            'data',
            'data_eskul',
            'berita_terbaru',
            'berita_terbaru2'
        ));
    }
    
    public function showByEskulAndSlug($eskul,$slug){
        $data_eskul = Eskul::where('slug', $eskul)->first();
        if (!$data_eskul) {
            abort(404);
        }
        $data = berita::where('eskul_id', $data_eskul->id)->where('slug',$slug)->with('eskul.eskul_detail')->first();
        if (!$data) {
            abort(404);
        }

        return view('frontpage.berita.showBySlug', compact(
            'data',
            'data_eskul'
        ));
    }
    
    public function fetchData(){
        $data = berita::with('eskul.eskul_detail')->orderBy('created_at', 'DESC')->paginate(9);

        return view('frontpage.berita.fetch_data.berita', compact(
            'data',
        ));
    }
}
