<?php

namespace App\Http\Controllers\admin;

use App\Models\admin\Berita;
use Illuminate\Http\Request;
use App\Models\admin\Anggota;
use App\Models\admin\Statistic;
use App\Models\admin\Dokumentasi;
use App\Models\admin\Pendaftaran;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        if (auth()->user()->eskul_id == 0 or null) {
            $anggota = Anggota::all();
            $pendaftar = Pendaftaran::all();
            $dokumentasi = Dokumentasi::all();
            $berita = Berita::all();
            $statistic = Statistic::all();
        } else {
            $anggota = Anggota::where('eskul_id',auth()->user()->eskul_id)->get();
            $pendaftar = Pendaftaran::where('eskul_id',auth()->user()->eskul_id)->get();
            $dokumentasi = Dokumentasi::where('eskul_id',auth()->user()->eskul_id)->get();
            $berita = Berita::where('eskul_id',auth()->user()->eskul_id)->get();
            $statistic = Statistic::all();
        }
        

        return view('administrator.dashboard.index' ,compact(
            'anggota',
            'pendaftar',
            'dokumentasi',
            'berita',
            'statistic',
        ));
    }

    public function getPendaftaran(){
        if (auth()->user()->eskul_id != 0) {
            $pendaftaran = Pendaftaran::where("eskul_id", auth()->user()->eskul_id)->with('eskul')->orderBy('created_at', 'desc')->limit(5)->get();
        }else {
            $pendaftaran = Pendaftaran::with('eskul')->orderBy('created_at', 'desc')->limit(5)->get();
        }

        return response()->json([
            'pendaftaran' => $pendaftaran,
        ]);
    }
}
