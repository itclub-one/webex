<?php

namespace App\Http\Controllers\frontpage;

use App\Models\admin\Eskul;
use App\Models\admin\Kelas;
use App\Models\admin\Berita;
use App\Models\admin\Sekbid;
use Illuminate\Http\Request;
use App\Models\admin\Jurusan;
use App\Models\admin\Dokumentasi;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        $eskul = Eskul::with('sekbid')->with('eskul_detail')->get();
        $dokumentasi = Dokumentasi::with('eskul.eskul_detail')->inRandomOrder()->limit(8)->get();
        $berita1 = Berita::with('eskul.eskul_detail')->inRandomOrder()->limit(1)->get();
        $berita5 = Berita::with('eskul.eskul_detail')->inRandomOrder()->limit(5)->get();

        return view('frontpage.home.index', compact(
            'eskul',
            'dokumentasi',
            'berita1',
            'berita5',
        ));
    }

    public function getSekbid(){
        $sekbid = Sekbid::all();

        return response()->json([
            'sekbid' => $sekbid,
        ]);
    }

    public function getEskul(){
        $eskul = Eskul::with('sekbid')->with('eskul_detail')->get();

        return response()->json([
            'eskul' => $eskul,
        ]);
    }

    public function getDokumentasi(){
        $dokumentasi = Dokumentasi::all();

        return response()->json([
            'dokumentasi' => $dokumentasi,
        ]);
    }

    public function getBerita(){
        $berita = Berita::all();

        return response()->json([
            'berita' => $berita,
        ]);
    }
    
    public function getKelas(){
        $kelas = Kelas::all();

        return response()->json([
            'kelas' => $kelas,
        ]);
    }
    
    public function getJurusan(){
        $jurusan = Jurusan::all();

        return response()->json([
            'jurusan' => $jurusan,
        ]);
    }
}
