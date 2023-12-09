<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\admin\Setting;
use App\Http\Controllers\Controller;

class SettingPendaftaranController extends Controller
{
    private static $module = "setting_pendaftaran";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        $settings = Setting::get()->toArray();
        
        $settings = array_column($settings, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.settings.pendaftaran.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // return $request;
        //Check permission
        if (!isAllowed(static::$module, "edit")) {
            abort(403);
        }
        

        $settings = Setting::get()->toArray();
        $settings = array_column($settings, 'value', 'name');

        
        $data_settings = [];
        $data_settings["status_pendaftaran"] = $request->status_pendaftaran ? $request->status_pendaftaran : 'tidak aktif';

        $logs = []; // Buat array kosong untuk menyimpan log

        foreach ($data_settings as $key => $value) {
            $data = [];

            if (array_key_exists($key, $settings)) {
                $data["value"] = $value;
                $set = Setting::where('name', $key)->first();
                $set->update($data);

                $logs[] = ['---'.$key.'---' => ['Data Sebelumnya' => ['value' => $settings[$key]], 'Data terbaru' => ['value' => $value]]];
            } else {
                $data["name"] = $key;
                $data["value"] = $value;
                $set = Setting::create($data);

                $logs[] = $set;
            }
        }

        

        // Setelah perulangan selesai, $logs akan berisi semua log untuk setiap data yang diproses.


        //Write log
        createLog(static::$module, __FUNCTION__, 0,$logs);

        return redirect(route('admin.settingPendaftaran'))->with(['success' => 'Data berhasil di update.']);

    }
}
