<?php

namespace App\Http\Controllers\admin;

use File;
use DataTables;
use App\Models\admin\Eskul;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\admin\Dokumentasi;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class DokumentasiController extends Controller
{
    private static $module = "dokumentasi";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.dokumentasi.index');
    }
    
    public function getData(Request $request){
        $data = Dokumentasi::query()->with('eskul');

        if ($request->eskul) {
            $data = $data->where(function ($query) use ($request) {
                if ($request->eskul != "") {
                    $query->where("eskul_id", $request->eskul);
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
                    $btn .= '<a href="'.route('admin.dokumentasi.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#detailDokumentasi">
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

        return view('administrator.dokumentasi.add');
    }
    
    public function save(Request $request){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $request->validate([
            'eskul' => 'required',
            'nama_kegiatan' => 'required',
            'caption' => 'required',
            'img_url' => 'required',
        ]);
    
        $data = Dokumentasi::create([
            'eskul_id' => $request->eskul,
            'nama_kegiatan' => $request->nama_kegiatan,
            'caption' => $request->caption,
            'img_url' => $request->img_url,
            'slug' => Str::slug($request->nama_kegiatan),
        ]);

        if ($request->hasFile('img_url')) {

            if (!empty($data->img_url)) {
                $image_path = "./administrator/assets/media/dokumentasi/" . $data->img_url;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $image = $request->file('img_url');
            $fileName = $data->nama_kegiatan . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
            $path = upload_path('dokumentasi') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $data['img_url'] = $fileName;
            $data->save();
        }
    
        createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => $data]);
        return redirect()->route('admin.dokumentasi')->with('success', 'Data berhasil disimpan.');
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Dokumentasi::with('eskul')->find($id);

        if (!$data) {
            abort(404);
        }

        return view('administrator.dokumentasi.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;

        $request->validate([
            'eskul' => 'required',
            'nama_kegiatan' => 'required',
            'caption' => 'required',
        ]);
        
        $data = Dokumentasi::findOrFail($id);

        $previousData = $data->toArray();

        $data->eskul_id = $request->eskul;
        $data->nama_kegiatan = $request->nama_kegiatan;
        $data->caption = $request->caption;
        $data->slug = Str::slug($request->nama_kegiatan);

        if ($request->hasFile('img_url')) {
            if (!empty($data->img_url)) {
                $image_path = "./administrator/assets/media/dokumentasi/" . $data->img_url;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                // Jika ada file gambar yang diunggah, simpan dan perbarui nama gambar
                $fileName = $data->nama_kegiatan . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $request->file('img_url')->getClientOriginalExtension();
                $path = upload_path('dokumentasi') . $fileName;
                Image::make($request->file('img_url')->getRealPath())->save($path, 100);
                $data->img_url = $fileName;
            }
        }

        $data->save();


        createLog(static::$module, __FUNCTION__, $data->id, ['Data sebelum diperbarui' => $previousData,'Data yang diperbarui' => $data]);
        return redirect()->route('admin.dokumentasi')->with('success', 'Data berhasil diperbarui.');
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
        $data = Dokumentasi::findorfail($id);

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

        $data = Dokumentasi::with('eskul')->find($id);

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => 'Sukses memuat detail.',
        ]);
    }

    public function getEskul(){
        if (auth()->user()->eskul_id != 0) {
            $eskul = Eskul::where("id", auth()->user()->eskul_id)->get();
        }else {
            $eskul = Eskul::all();
        }

        return response()->json([
            'eskul' => $eskul,
        ]);
    }
}
