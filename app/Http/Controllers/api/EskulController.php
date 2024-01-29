<?php

namespace App\Http\Controllers\api;

use App\Models\admin\Eskul;
use Illuminate\Http\Request;
use App\Models\admin\Anggota;
use App\Http\Controllers\Controller;
use App\Models\admin\JadwalKumpulan;
use Illuminate\Validation\Validator;

class EskulController extends Controller
{
    public function index(){
        $query = Eskul::with('sekbid')->with('eskul_detail')->orderBy('sekbid_id', 'asc')->get();
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Data successfully',
            'data' => $query
        ], 200);
    }
    
    public function detail(Request $request, $slug){
        $query = Eskul::with('sekbid')->with('eskul_detail')->where('slug', $slug)->first();
        if (!$query) {
            return response()->json([
                'code' => 404,
                'status' => 'Not Found'
            ], 404);
        }
        $jadwal_kumpulan = JadwalKumpulan::where('eskul_id', $query->id)->with('jadwal')->get();
        $anggota = Anggota::with('kelas')->with('jurusan')->where('eskul_id', $query->id)->get();
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Data successfully',
            'data' => ['eskul' => $query, 'jadwal_kumpulan' => $jadwal_kumpulan, 'anggota' => $anggota]
        ], 200);
    }
}
