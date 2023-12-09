<?php

namespace App\Http\Controllers\frontpage;

use DataTables;
use App\Models\admin\Eskul;
use Illuminate\Http\Request;
use App\Models\admin\Anggota;
use App\Models\admin\Dokumentasi;
use App\Http\Controllers\Controller;
use App\Models\admin\JadwalKumpulan;

class EskulController extends Controller
{
    public function index(){
        $data = Eskul::with('eskul_detail')->paginate(8);

        return view('frontpage.eskul.index',compact(
            'data'
        ));
    }
    
    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            $data = Eskul::with('eskul_detail')->paginate(8);
            return view('frontpage.eskul.fetch_data.eskul', compact('data'))->render();
        }
    }
    
    public function showBySlug($slug){
        $data = Eskul::where('slug',$slug)->with('eskul_detail')->first();
        if (!$data) {
            abort(404);
        }
        $dokumentasiByEskul = Dokumentasi::where('eskul_id',$data->id)->with('eskul.eskul_detail')->paginate(4);


        return view('frontpage.eskul.showBySlug',compact(
            'data',
            'dokumentasiByEskul',
        ));
    }
    
    public function fetchDataDokumentasi(Request $request,$slug)
    {
        if ($request->ajax()) {
            $data = Eskul::where('slug',$slug)->with('eskul_detail')->first();
            $dokumentasiByEskul = Dokumentasi::where('eskul_id',$data->id)->with('eskul.eskul_detail')->paginate(4);
            return view('frontpage.eskul.fetch_data.dokumentasi', compact('dokumentasiByEskul'))->render();
        }
    }
    
    public function getEskulBySlug(Request $request){
        $slug = $request->slug;
        $eskul = Eskul::where('slug',$slug)->with('eskul_detail')->with('sekbid')->first();
        $jadwal_kumpulan = JadwalKumpulan::where('eskul_id',$eskul->id)->with('jadwal')->get();

        return response()->json([
            'eskul' => $eskul,
            'jadwal_kumpulan' => $jadwal_kumpulan,
        ]);
    }

    public function getDataAnggota(Request $request){
        $data = Anggota::query()->with('eskul')->with('kelas')->with('jurusan');

        if (!empty($request->id)) {
            $data->where("eskul_id", $request->id);
        }

        $data = $data->get();

        return DataTables::of($data)
            ->make(true);
    }
}
