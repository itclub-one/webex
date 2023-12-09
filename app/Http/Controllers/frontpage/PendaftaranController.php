<?php

namespace App\Http\Controllers\frontpage;

use App\Mail\DaftarMail;
use App\Models\admin\Eskul;
use Illuminate\Http\Request;
use App\Models\admin\Pendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PendaftaranController extends Controller
{
    public function index(){
        return view('frontpage.pendaftaran.index');
    }

    public function save(Request $request){
        try {
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
            
            $eskul = Eskul::where('id', $request->eskul)->first();
            $pendaftaran = Pendaftaran::where('eskul_id', $eskul->id)->where('nis', $request->nis)->first();

            $mailData = [
                'title' => '[Webex] Hi,'. $pendaftaran->nama,
                'content' => 'Anda telah mendaftar di Ekstrakurikuler '. $eskul->nama .'.',
                'nama' => $pendaftaran->nama,
                'nis' => $pendaftaran->nis,
                'kelas' => $pendaftaran->kelas->kode,
                'jurusan' => $pendaftaran->jurusan->nama,
                'email' => $pendaftaran->email,
                'telepon' => $pendaftaran->telepon,
                'alasan_masuk' => $pendaftaran->alasan_masuk,
            ];
    
            $recipientEmail = $pendaftaran->email;
    
            Mail::to($recipientEmail)->send(new DaftarMail($mailData));

    
            createLog('pendaftaran', __FUNCTION__, $data->id, ['Data web yang disimpan' => $data]);
            return redirect()->route('web.pendaftaran')->with('success', 'Berhasil mendaftar ke ' . $eskul->nama);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('web.pendaftaran')->with('error', 'Gagal mendaftar. Periksa kembali input Anda.');
        }
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
}
