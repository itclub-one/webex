<?php

namespace App\Http\Controllers\admin;

use DataTables;
use App\Models\admin\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    private static $module = "kelas";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.kelas.index');
    }
    
    public function getData(Request $request){
        $data = Kelas::query();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="'.route('admin.kelas.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
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

        return view('administrator.kelas.add');
    }
    
    public function save(Request $request){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $request->validate([
            'kode' => 'required|unique:kelas',
            'kelas' => 'required|unique:kelas',
            'alias' => 'required',
        ]);
    
        $data = Kelas::create([
            'kode' => $request->kode,
            'kelas' => $request->kelas,
            'alias' => $request->alias,
        ]);
    
        createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => $data]);
        return redirect()->route('admin.kelas')->with('success', 'Data berhasil disimpan.');
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Kelas::find($id);

        if (!$data) {
            abort(404);
        }

        return view('administrator.kelas.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = Kelas::find($id);

        $request->validate([
            'kode' => 'required|unique:kelas,kode,' . $id,
            'kelas' => 'required|unique:kelas,kelas,' . $id,
            'alias' => 'required',
        ]);
    
        // Simpan data sebelum diupdate
        $previousData = $data->toArray();

        $updates = [
            'kode' => $request->kode,
            'kelas' => $request->kelas,
            'alias' => $request->alias,
        ];


        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());

        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data sebelum diupdate' => $previousData, 'Data sesudah diupdate' => $updatedData]);
        return redirect()->route('admin.kelas')->with('success', 'Data berhasil diupdate.');
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
        $data = Kelas::findorfail($id);

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

    public function checkKelas(Request $request){
        if($request->ajax()){
            $data = Kelas::where('kelas', $request->kelas);
            
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
    
    public function checkKodeRomawi(Request $request){
        if($request->ajax()){
            $data = Kelas::where('kode', $request->kode);
            
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
}
