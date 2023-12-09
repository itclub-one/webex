<?php

namespace App\Http\Controllers\admin;

use File;
use DataTables;
use App\Models\admin\Eskul;
use Illuminate\Support\Str;
use App\Models\admin\Jadwal;
use App\Models\admin\Sekbid;
use Illuminate\Http\Request;
use App\Models\admin\EskulDetail;
use App\Http\Controllers\Controller;
use App\Models\admin\JadwalKumpulan;
use Intervention\Image\Facades\Image;

class EskulController extends Controller
{
    private static $module = "eskul";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.eskul.index');
    }
    
    public function getData(Request $request){
        $data = Eskul::query()->with('sekbid');

        if ($request->sekbid) {
            $data = $data->where(function ($query) use ($request) {
                if ($request->sekbid != "") {
                    $query->where("sekbid_id", $request->sekbid);
                }
            });
        }

        if (auth()->user()->eskul_id != 0) {
            $data->where("id", auth()->user()->eskul_id);
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
                    $btn .= '<a href="'.route('admin.eskul.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#detailEskul">
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

        return view('administrator.eskul.add');
    }
    
    public function save(Request $request){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|unique:eskul,nama',
            'sekbid' => 'required',
            'pembina' => 'required',
            'ketua' => 'required',
            'wakil_ketua' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'program_kerja' => 'required',
            'logo_url' => 'required',
            'jadwal_kumpulan' => 'required|array',
        ]);
    
        // dd($request->jadwal_kumpulan);

        $data = Eskul::create([
            'nama' => $request->nama,
            'sekbid_id' => $request->sekbid,
            'slug' => Str::slug($request->nama),
        ]);

        $detail = EskulDetail::create([
            'eskul_id' => $data->id,
            'logo_url' => $request->logo_url,
            'pembina' => $request->pembina,
            'ketua' => $request->ketua,
            'wakil_ketua' => $request->wakil_ketua,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'program_kerja' => $request->program_kerja,
            'sosial_media' => '{
                "linkedin": "",
                "twitter": "",
                "instagram": "'.$request->sosmed_instagram ?? '-'.'",
                "facebook": "",
                "youtube": ""
              }',
        ]);

        // Menyimpan jadwal_kumpulan yang dipilih
        $jadwalKumpulan = $request->jadwal_kumpulan;
        foreach ($jadwalKumpulan as $jadwalId) {
            // Membuat data jadwal_kumpulan
            JadwalKumpulan::create([
                'eskul_id' => $data->id,
                'jadwal_id' => $jadwalId,
            ]);
        }

        if ($request->hasFile('logo_url')) {

            if (!empty($detail->logo_url)) {
                $image_path = "./administrator/assets/media/eskul/" . $detail->logo_url;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $image = $request->file('logo_url');
            $fileName = 'logo_' . $data->nama . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $image->getClientOriginalExtension();
            $path = upload_path('eskul') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $detail['logo_url'] = $fileName;
            $detail->save();
        }
    
        createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => ['Eskul' => $data, 'Eskul Detail' => $detail]]);
        return redirect()->route('admin.eskul')->with('success', 'Data berhasil disimpan.');
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Eskul::with('eskul_detail')->with('sekbid')->find($id);
        if (!$data) {
            abort(404);
        }

        if (!empty($data->eskul_detail->sosial_media)) {
            # code...
            $sosmed = json_decode($data->eskul_detail->sosial_media, true); // Mengubah JSON menjadi array
        }else{
            $sosmed = '';
        }

        return view('administrator.eskul.edit',compact('data','sosmed'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;

        $request->validate([
            'nama' => 'required|unique:eskul,nama,' . $id,
            'sekbid' => 'required',
            'pembina' => 'required',
            'ketua' => 'required',
            'wakil_ketua' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'program_kerja' => 'required',
        ]);
        
        $data = Eskul::findOrFail($id);
        $previousData = $data->toArray();
        $data->update([
            'nama' => $request->nama,
            'sekbid_id' => $request->sekbid,
            'slug' => Str::slug($request->nama),
        ]);

        $detail = EskulDetail::where('eskul_id', $id)->first();
        if (!$detail) {
            // Jika detail Eskul tidak ada, buat detail baru
            $detail = new EskulDetail();
            $detail->eskul_id = $id;
        }

        $logo = $request->hasFile('logo_url') ? $request->file('logo_url') : $detail->logo_url;
        $detail->pembina = $request->pembina;
        $detail->ketua = $request->ketua;
        $detail->wakil_ketua = $request->wakil_ketua;
        $detail->visi = $request->visi;
        $detail->misi = $request->misi;
        $detail->program_kerja = $request->program_kerja;
        $detail->sosial_media = json_encode([
            'linkedin' => '',
            'twitter' => '',
            'instagram' => $request->sosmed_instagram ?? '-',
            'facebook' => '',
        ]);

        if ($request->hasFile('logo_url')) {
            if (!empty($detail->logo_url)) {
                $image_path = "./administrator/assets/media/eskul/" . $detail->logo_url;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            // Jika ada file logo yang diunggah, simpan dan perbarui nama logo
            $fileName = 'logo_' . $data->nama . '_' . date('Y-m-d-H-i-s') . '_' . uniqid(2) . '.' . $logo->getClientOriginalExtension();
            $path = upload_path('eskul') . $fileName;
            Image::make($logo->getRealPath())->save($path, 100);
            $detail->logo_url = $fileName;
        }

        $detail->save();

        $jadwalKumpulan = $request->jadwal_kumpulan;
        // Hapus jadwal_kumpulan yang sudah ada terkait eskul ini
        JadwalKumpulan::where('eskul_id', $id)->delete();
        foreach ($jadwalKumpulan as $jadwalId) {
            // Membuat data jadwal_kumpulan
            JadwalKumpulan::create([
                'eskul_id' => $id,
                'jadwal_id' => $jadwalId,
            ]);
        }

        createLog(static::$module, __FUNCTION__, $data->id, ['Data sebelum diperbarui' => $previousData,'Data yang diperbarui' => ['Eskul' => $data, 'Eskul Detail' => $detail]]);
        return redirect()->route('admin.eskul')->with('success', 'Data berhasil diperbarui.');
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
        $data = Eskul::findorfail($id);

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

        $detail = EskulDetail::where('eskul_id', $id)->first();

        if ($detail) {
            // Check if the detail is being force-deleted
            $detail->delete();
        }

        // Write logs only for soft delete (not force delete)
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dihapus' => ['User' => $deletedData, 'User Profile' => $detail]]);

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

        $data = Eskul::with('eskul_detail')->with('sekbid')->find($id);
        $jadwal_kumpulan = JadwalKumpulan::where('eskul_id',$id)->with('jadwal')->get();

        return response()->json([
            'data' => $data,
            'jadwal_kumpulan' => $jadwal_kumpulan,
            'status' => 'success',
            'message' => 'Sukses memuat detail.',
        ]);
    }
    
    public function getSekbid(){
        $sekbid = Sekbid::all();

        return response()->json([
            'sekbid' => $sekbid,
        ]);
    }
    
    public function getJadwal(){
        $jadwal = Jadwal::all();

        return response()->json([
            'jadwal' => $jadwal,
        ]);
    }
    
    public function checkNama(Request $request){
        if($request->ajax()){
            $users = Eskul::where('nama', $request->nama)->withTrashed();
            
            if(isset($request->id)){
                $users->where('id', '!=', $request->id);
            }
    
            if($users->exists()){
                return response()->json([
                    'message' => 'Nama sudah dipakai',
                    'valid' => false
                ]);
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
    
    public function arsip(){
        //Check permission
        if (!isAllowed(static::$module, "arsip")) {
            abort(403);
        }

        return view('administrator.eskul.arsip');
    }

    public function getDataArsip(Request $request){
        $data = Eskul::query()
                    ->with('sekbid')
                    ->onlyTrashed();

        if ($request->sekbid) {
            $data = $data->where(function ($query) use ($request) {
                if ($request->sekbid != "") {
                    $query->where("sekbid_id", $request->sekbid);
                }
            });
        }

        if (auth()->user()->eskul_id != 0) {
            $data->where("id", auth()->user()->eskul_id);
        }

        $data = $data->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "force_delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "restore")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-primary restore btn-sm mx-3 ">
                    Restore
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function restore(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "restore")) {
            abort(403);
        }
        
        $id = $request->id;
        $data = Eskul::withTrashed()->find($id);
        $detail = EskulDetail::withTrashed()->where('eskul_id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        if (!$detail) {
            $detail = EskulDetail::create([
                'eskul_id' => $id,
            ]);
            $eskulDetailtoarray = '';
        } else {
            # code...
            $eskulDetailtoarray = "'Detail' => $detail->toArray() ";
        }
        // Simpan data sebelum diupdate
        $previousData = [
            'Data' => $data->toArray(),
            $eskulDetailtoarray
        ];

        $data->restore();
        if (!empty($detail)) {
            $detail->restore();
        }

        $updated = ['Data' => $data, 'Detail' => $detail];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, ['Data yang dipulihkan' => $updated]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah dipulihkan.'
        ]);
    }


    public function forceDelete(Request $request)
    {
        //Check permission
        if (!isAllowed(static::$module, "force_delete")) {
            abort(403);
        }
        
        $id = $request->id;

        $data = Eskul::withTrashed()->find($id);
        $detail = EskulDetail::withTrashed()->where('eskul_id',$id)->first();

        if (!$data) {
            return redirect()->route('admin.eskul.arsip')->with('error', 'Data tidak ditemukan.');
        }

        $data->forceDelete();
        if (!empty($detail)) {
            if (!empty($detail->logo_url)) {
                $image_path = "./administrator/assets/media/eskul/" . $detail->logo_url;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $detail->forceDelete();
            $dataJsonDetail = $detail;
        } else {
            $dataJsonDetail = '';
        }

        $dataJson = [
            $data,$dataJsonDetail
        ];

        // Write logs if needed.
        createLog(static::$module, __FUNCTION__, $id, $dataJson);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data telah dihapus secara permanent.',
        ]);
    }
}
