<?php

namespace App\Http\Controllers\admin;

use DataTables;
use Excel;
use App\Models\admin\Eskul;
use App\Models\admin\Kelas;
use Illuminate\Http\Request;
use App\Models\admin\Anggota;
use App\Models\admin\Jurusan;
use App\Http\Controllers\Controller;
use App\Exports\Anggota as ExportAnggota;

class AnggotaController extends Controller
{
    private static $module = "anggota";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.anggota.index');
    }
    
    public function getData(Request $request){
        $data = Anggota::query()->with('eskul')->with('kelas')->with('jurusan');

        if ($request->eskul || $request->kelas || $request->jurusan) {
            $data = $data->where(function ($query) use ($request) {
                if ($request->eskul != "") {
                    $query->where("eskul_id", $request->eskul);
                }
                if ($request->kelas != "") {
                    $query->where("kelas_id", $request->kelas);
                }
                if ($request->jurusan != "") {
                    $query->where("jurusan_id", $request->jurusan);
                }
            });
        }

        if (auth()->user()->eskul_id != 0) {
            $data->where("eskul_id", auth()->user()->eskul_id);
        }

        $data = $data->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="'.route('admin.anggota.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#detailAnggota">
                    Detail
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    
    public function add(){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.anggota.add');
    }
    
    public function save(Request $request){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'nis' => 'required|unique:anggota,nis',
            'telepon' => 'required|unique:anggota,telepon',
            'email' => 'required|unique:anggota,email',
            'eskul' => 'required',
        ]);
    
        $data = Anggota::create([
            'nama' => $request->nama,
            'kelas_id' => $request->kelas,
            'jurusan_id' => $request->jurusan,
            'nis' => $request->nis,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'eskul_id' => $request->eskul,
        ]);
    
        createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => $data]);
        return redirect()->route('admin.anggota')->with('success', 'Data berhasil disimpan.');
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Anggota::find($id);

        if (!$data) {
            abort(404);
        }

        return view('administrator.anggota.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = Anggota::find($id);

        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'nis' => 'required|unique:anggota,nis,' . $id,
            'telepon' => 'required|unique:anggota,telepon,' . $id,
            'email' => 'required|unique:anggota,email,' . $id,
            'eskul' => 'required',
        ]);
    
        // Simpan data sebelum diupdate
        $previousData = $data->toArray();

        $updates = [
            'nama' => $request->nama,
            'kelas_id' => $request->kelas,
            'jurusan_id' => $request->jurusan,
            'nis' => $request->nis,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'eskul_id' => $request->eskul,
        ];


        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());

        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data sebelum diupdate' => $previousData, 'Data sesudah diupdate' => $updatedData]);
        return redirect()->route('admin.anggota')->with('success', 'Data berhasil diupdate.');
    }

    
    
    
    public function delete(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "delete")) {
            abort(403);
        }

        // Ensure you have authorization mechanisms here before proceeding to delete data.

        $id = $request->id;

        // Find the data based on the provided ID.
        $data = Anggota::findorfail($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        // Delete the data.
        $data->delete();

        // Write logs only for soft delete (not force delete)
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => $deletedData]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengguna telah dihapus.',
        ]);
    }

    public function getDetail($id){
        //Check permission
        if (!isAllowed(static::$module, "detail")) {
            abort(403);
        }

        $data = Anggota::with('eskul')->with('kelas')->with('jurusan')->find($id);

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Sukses memuat detail.',
        ]);
    }

    public function getEskul(){
        if (auth()->user()->eskul_id != 0) {
            $eskul = Eskul::where("id", auth()->user()->eskul_id)->get();
        } else {
            $eskul = Eskul::all();
        }

        return response()->json([
            'eskul' => $eskul,
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

    public function checkEmail(Request $request){
        if($request->ajax()){
            $data = Anggota::where('email', $request->email);
            
            if(isset($request->id)){
                $data->where('id', '!=', $request->id);
            }
    
            if($data->exists()){
                return response()->json([
                    'message' => 'Data sudah dipakai',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
    
    public function checkTelepon(Request $request){
        if($request->ajax()){
            $data = Anggota::where('telepon', $request->telepon);
            
            if(isset($request->id)){
                $data->where('id', '!=', $request->id);
            }
    
            if($data->exists()){
                return response()->json([
                    'message' => 'Data sudah dipakai',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
    
    public function checkNis(Request $request){
        if($request->ajax()){
            $data = Anggota::where('nis', $request->nis);
            
            if(isset($request->id)){
                $data->where('id', '!=', $request->id);
            }
    
            if($data->exists()){
                return response()->json([
                    'message' => 'Data sudah dipakai',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }

    public function export(){
        if (auth()->user()->kode == 'dev_daysf' || auth()->user()->eskul_id == 0) {
            $title = 'Anggota Ekstrakurikuler.xlsx';
        } else {
            $title = 'Anggota Ekstrakurikuler ' . auth()->user()->eskul->nama . '.xlsx';
        }
        return Excel::download(new ExportAnggota, $title);
    }
}
