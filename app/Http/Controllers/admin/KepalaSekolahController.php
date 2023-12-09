<?php

namespace App\Http\Controllers\admin;

use DB;
use File;
use DataTables;
use App\Models\admin\Setting;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KepalaSekolahController extends Controller
{
    private static $module = "setting_kepala_sekolah";

    public function index()
    {
        //Check permission
        if (!isAllowed(static::$module, "view")) {
            abort(403);
        }
        $settings = Setting::get()->toArray();
        
        $settings = array_column($settings, 'value', 'name');

        // Ambil pengaturan dari database dan tampilkan di halaman
        return view('administrator.kepala_sekolah.index', compact('settings'));
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
        $data_settings["nama_kepsek"] = $request->nama_kepsek;
        $data_settings["content_kepsek"] = $request->content_kepsek;
        

        if ($request->hasFile('image_kepsek')) {
            if (array_key_exists("image_kepsek", $settings)) {
                $imageBefore = $settings["image_kepsek"];
                if (!empty($settings["image_kepsek"])) {
                    $image_path = "./administrator/assets/media/settings/" . $settings["image_kepsek"];
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }

            $image = $request->file('image_kepsek');
            $fileName  =  'image_kepsek.' . $image->getClientOriginalExtension();
            $path = upload_path('settings') . $fileName;
            Image::make($image->getRealPath())->save($path, 100);
            $data_settings['image_kepsek'] = $fileName;
        }
        // elseif ($request->has('remove_image_kepsek')) {
        //     if (array_key_exists("image_kepsek", $settings) && !empty($settings["image_kepsek"])) {
        //         $image_path = "./administrator/assets/media/settings/" . $settings["image_kepsek"];
        //         if (File::exists($image_path)) {
        //             File::delete($image_path);
        //         }
        //         $data_settings['image_kepsek'] = null;
        //     }
        // }

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

        return redirect(route('admin.kepala_sekolah'))->with(['success' => 'Data berhasil di update.']);

    }
}
