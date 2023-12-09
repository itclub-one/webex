<?php

namespace App\Http\Controllers\admin;

use Excel;
use DataTables;
use App\Models\admin\Eskul;
use App\Models\admin\Kelas;
use Illuminate\Http\Request;
use App\Models\admin\Anggota;
use App\Models\admin\Jurusan;
use App\Mail\StatusPendaftarMail;
use App\Models\admin\Pendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Exports\Pendaftaran as PendaftaranExport;

class PendaftaranController extends Controller
{
    private static $module = "pendaftaran";

    public function index(){
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }

        return view('administrator.pendaftaran.index');
    }
    
    public function getData(Request $request){
        $data = Pendaftaran::query()->with('eskul')->with('kelas')->with('jurusan');

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
            ->addColumn('status', function ($row) {
                $btn = "";
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-success btn-sm accept mx-1">
                    Accept
                </a>';
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-warning btn-sm reject mx-1">
                    Reject
                </a>';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = "";
                if (isAllowed(static::$module, "delete")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-danger btn-sm delete  ">
                    Delete
                </a>';
                endif;
                if (isAllowed(static::$module, "edit")) : //Check permission
                    $btn .= '<a href="'.route('admin.pendaftaran.edit',$row->id).'" class="btn btn-primary btn-sm mx-3 ">
                    Edit
                </a>';
                endif;
                if (isAllowed(static::$module, "detail")) : //Check permission
                    $btn .= '<a href="#" data-id="' . $row->id . '" class="btn btn-secondary btn-sm " data-toggle="modal" data-target="#detailPendaftaran">
                    Detail
                </a>';
                endif;
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }
    
    public function add(){
        //Check permission
        if (!isAllowed(static::$module, "add")) {
            abort(403);
        }

        return view('administrator.pendaftaran.add');
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
            'nis' => 'required',
            'telepon' => 'required',
            'email' => 'required',
            'eskul' => 'required',
            'alasan_masuk' => 'required',
        ]);
    
        $data = Pendaftaran::create([
            'nama' => $request->nama,
            'kelas_id' => $request->kelas,
            'jurusan_id' => $request->jurusan,
            'nis' => $request->nis,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'eskul_id' => $request->eskul,
            'alasan_masuk' => $request->alasan_masuk,
        ]);
    
        createLog(static::$module, __FUNCTION__, $data->id, ['Data yang disimpan' => $data]);
        return redirect()->route('admin.pendaftaran')->with('success', 'Data berhasil disimpan.');
    }
    
    
    public function edit($id){
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $data = Pendaftaran::find($id);

        if (!$data) {
            abort(404);
        }

        return view('administrator.pendaftaran.edit',compact('data'));
    }
    
    public function update(Request $request)
    {
        // Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }

        $id = $request->id;
        $data = Pendaftaran::find($id);

        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'jurusan' => 'required',
            'nis' => 'required',
            'telepon' => 'required',
            'email' => 'required',
            'eskul' => 'required',
            'alasan_masuk' => 'required',
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
            'alasan_masuk' => $request->alasan_masuk,
        ];


        // Filter only the updated data
        $updatedData = array_intersect_key($updates, $data->getOriginal());

        $data->update($updates);

        createLog(static::$module, __FUNCTION__, $data->id, ['Data sebelum diupdate' => $previousData, 'Data sesudah diupdate' => $updatedData]);
        return redirect()->route('admin.pendaftaran')->with('success', 'Data berhasil diupdate.');
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
        $data = Pendaftaran::findorfail($id);

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

        $data = Pendaftaran::with('eskul')->with('kelas')->with('jurusan')->find($id);

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
        if ($request->ajax()) {
            $data = Pendaftaran::where('email', $request->email);
    
            if (isset($request->id)) {
                $data->where('id', '!=', $request->id);
            }
    
            if ($data->exists()) {
                // Check if there's a record with the same email and eskul
                $existingRecord = $data->first();
    
                if ($existingRecord->eskul_id == $request->eskul) {
                    return response()->json([
                        'message' => 'Data sudah dipakai',
                        'valid' => false
                    ]);
                } else {
                    return response()->json([
                        'valid' => true
                    ]);
                }
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
    
    
    public function checkTelepon(Request $request){
        if ($request->ajax()) {
            $data = Pendaftaran::where('telepon', $request->telepon);
    
            if (isset($request->id)) {
                $data->where('id', '!=', $request->id);
            }
    
            if ($data->exists()) {
                // Check if there's a record with the same telephone number and eskul
                $existingRecord = $data->first();
    
                if ($existingRecord->eskul_id == $request->eskul) {
                    return response()->json([
                        'message' => 'Data sudah dipakai',
                        'valid' => false
                    ]);
                } else {
                    return response()->json([
                        'valid' => true
                    ]);
                }
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
    
    
    public function checkNis(Request $request){
        if ($request->ajax()) {
            $data = Pendaftaran::where('nis', $request->nis);
    
            if (isset($request->id)) {
                $data->where('id', '!=', $request->id);
            }
    
            if ($data->exists()) {
                // Check if there's a record with the same NIS and eskul
                $existingRecord = $data->first();
    
                if ($existingRecord->eskul_id == $request->eskul) {
                    return response()->json([
                        'message' => 'Data sudah dipakai',
                        'valid' => false
                    ]);
                } else {
                    return response()->json([
                        'valid' => true
                    ]);
                }
            } else {
                return response()->json([
                    'valid' => true
                ]);
            }
        }
    }
    

    public function accept(Request $request){

        $id = $request->id;

        $pendaftaran = Pendaftaran::where('id',$id)->with('eskul')->first();
        $anggota = Anggota::where('email', $pendaftaran->email)
            ->orWhere('telepon', $pendaftaran->telepon)
            ->orWhere('nis', $pendaftaran->nis)
            ->first(); // Menggunakan first() daripada firstOrFail()
            // dd($anggota);
        if (!empty($anggota)) {
            if ($pendaftaran->eskul_id != $anggota->eskul_id) {
                # code...
                $data = Anggota::create([
                    'nama' => $pendaftaran->nama,
                    'kelas_id' => $pendaftaran->kelas_id,
                    'jurusan_id' => $pendaftaran->jurusan_id,
                    'nis' => $pendaftaran->nis,
                    'telepon' => $pendaftaran->telepon, 
                    'email' => $pendaftaran->email,
                    'eskul_id' => $pendaftaran->eskul_id,
                ]);
            
                $pendaftaran->delete();
                
                $mailData = [
                'title' => '[Webex] Selamat '. $pendaftaran->nama,
                'content' => 'Anda telah diterima di Ekstrakurikuler '. $pendaftaran->eskul->nama .'.',
                'nama' => $pendaftaran->nama,
                'nis' => $pendaftaran->nis,
                'kelas' => $pendaftaran->kelas->kode,
                'jurusan' => $pendaftaran->jurusan->nama,
                'email' => $pendaftaran->email,
                'telepon' => $pendaftaran->telepon,
                'alasan_masuk' => $pendaftaran->alasan_masuk,
                'status' => 'accept',
            ];
    
            $recipientEmail = $pendaftaran->email;
    
            Mail::to($recipientEmail)->send(new StatusPendaftarMail($mailData));

                return response()->json([
                    'status' => 'success',
                    'message' => 'Data telah pindahkan.',
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sudah ada di Anggota 1'
                ], 400);
            }
        } elseif (empty($anggota)) {
            $data = Anggota::create([
                'nama' => $pendaftaran->nama,
                'kelas_id' => $pendaftaran->kelas_id,
                'jurusan_id' => $pendaftaran->jurusan_id,
                'nis' => $pendaftaran->nis,
                'telepon' => $pendaftaran->telepon,
                'email' => $pendaftaran->email,
                'eskul_id' => $pendaftaran->eskul_id,
            ]);
        
            $pendaftaran->delete();
            
            $mailData = [
                'title' => '[Webex] Selamat '. $pendaftaran->nama,
                'content' => 'Anda telah diterima di Ekstrakurikuler '. $pendaftaran->eskul->nama .'.',
                'nama' => $pendaftaran->nama,
                'nis' => $pendaftaran->nis,
                'kelas' => $pendaftaran->kelas->kode,
                'jurusan' => $pendaftaran->jurusan->nama,
                'email' => $pendaftaran->email,
                'telepon' => $pendaftaran->telepon,
                'alasan_masuk' => $pendaftaran->alasan_masuk,
                'status' => 'accept',
            ];
    
            $recipientEmail = $pendaftaran->email;
    
            Mail::to($recipientEmail)->send(new StatusPendaftarMail($mailData));
            
            return response()->json([
                'status' => 'success',
                'message' => 'Data telah pindahkan.',
            ]);
        } else{
            return response()->json([
                'status' => 'error',
                'message' => 'Sudah ada di Anggota 2'
            ], 400);
        }

        
    }

    public function reject(Request $request)
    {
        $id = $request->id;

        // Find the data based on the provided ID.
        $data = Pendaftaran::findorfail($id);

        if (!$data) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Store the data to be logged before deletion
        $deletedData = $data->toArray();

        // Delete the data.
        $data->delete();

        $mailData = [
            'title' => '[Webex] Jangan menyerah ya ' . $data->nama,
            'content' => 'Anda tidak diterima di Ekstrakurikuler '. $data->eskul->nama .'.',
            'nama' => $data->nama,
            'nis' => $data->nis,
            'kelas' => $data->kelas->kode,
            'jurusan' => $data->jurusan->nama,
            'email' => $data->email,
            'telepon' => $data->telepon,
            'alasan_masuk' => $data->alasan_masuk,
            'status' => 'reject',
        ];

        $recipientEmail = $data->email;

        Mail::to($recipientEmail)->send(new StatusPendaftarMail($mailData));

        // Write logs only for soft delete (not force delete)

        return response()->json([
            'status' => 'success',
            'message' => 'Data telah dihapus.',
        ]);
    }

    public function export(){
        if (auth()->user()->kode == 'dev_daysf' || auth()->user()->eskul_id == 0) {
            $title = 'Pendaftaran Ekstrakurikuler.xlsx';
        } else {
            $title = 'Pendaftaran Ekstrakurikuler ' . auth()->user()->eskul->nama . '.xlsx';
        }

        return Excel::download(new PendaftaranExport, $title);
    }
}
