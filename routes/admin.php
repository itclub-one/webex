<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\viewController;
use App\Http\Controllers\admin\EskulController;
use App\Http\Controllers\admin\KelasController;
use App\Http\Controllers\admin\BeritaController;
use App\Http\Controllers\admin\JadwalController;
use App\Http\Controllers\admin\ModuleController;
use App\Http\Controllers\admin\SekbidController;
use App\Http\Controllers\admin\AnggotaController;
use App\Http\Controllers\admin\JurusanController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\LogSystemController;
use App\Http\Controllers\admin\UserGroupController;
use App\Http\Controllers\admin\DokumentasiController;
use App\Http\Controllers\admin\PendaftaranController;
use App\Http\Controllers\admin\KepalaSekolahController;
use App\Http\Controllers\admin\SettingPendaftaranController;
use App\Http\Controllers\admin\WakilKepalaSekolahController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ------------------------------------------  Admin -----------------------------------------------------------------
Route::prefix('admin')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('login/checkEmail', [AuthController::class, 'checkEmail'])->name('admin.login.checkEmail');
    Route::post('login/checkPassword', [AuthController::class, 'checkPassword'])->name('admin.login.checkPassword');
    Route::post('loginProses', [AuthController::class, 'loginProses'])->name('admin.loginProses');
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');
    
    Route::get('main-admin', [viewController::class, 'main_admin'])->name('main_admin');

    Route::middleware(['auth.admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('dashboard/getPendaftaran', [DashboardController::class, 'getPendaftaran'])->name('admin.dashboard.getPendaftaran');

        //Log Systems
        Route::get('log-systems', [LogSystemController::class, 'index'])->name('admin.logSystems');
        Route::get('log-systems/getData', [LogSystemController::class, 'getData'])->name('admin.logSystems.getData');
        Route::get('log-systems/getDataModule', [LogSystemController::class, 'getDataModule'])->name('admin.logSystems.getDataModule');
        Route::get('log-systems/getDataUser', [LogSystemController::class, 'getDataUser'])->name('admin.logSystems.getDataUser');
        Route::get('log-systems/getDetail{id}', [LogSystemController::class, 'getDetail'])->name('admin.logSystems.getDetail');
        Route::get('log-systems/clearLogs', [LogSystemController::class, 'clearLogs'])->name('admin.logSystems.clearLogs');
        Route::get('log-systems/generatePDF', [LogSystemController::class, 'generatePDF'])->name('admin.logSystems.generatePDF');
    
        //User Group
        Route::get('user-groups', [UserGroupController::class, 'index'])->name('admin.user_groups');
        Route::get('user-groups/add', [UserGroupController::class, 'add'])->name('admin.user_groups.add');
        Route::get('user-groups/getData', [UserGroupController::class, 'getData'])->name('admin.user_groups.getData');
        Route::post('user-groups/save', [UserGroupController::class, 'save'])->name('admin.user_groups.save');
        Route::get('user-groups/edit/{id}', [UserGroupController::class, 'edit'])->name('admin.user_groups.edit');
        Route::put('user-groups/update', [UserGroupController::class, 'update'])->name('admin.user_groups.update');
        Route::delete('user-groups/delete', [UserGroupController::class, 'delete'])->name('admin.user_groups.delete');
        Route::get('user-groups/getDetail-{id}', [UserGroupController::class, 'getDetail'])->name('admin.user_groups.getDetail');
        Route::post('user-groups/changeStatus',[UserGroupController::class, 'changeStatus'])->name('admin.user_groups.changeStatus');
        Route::post('user-groups/checkName',[UserGroupController::class, 'checkName'])->name('admin.user_groups.checkName');
        
        //User
        Route::get('users', [UserController::class, 'index'])->name('admin.users');
        Route::get('users/add', [UserController::class, 'add'])->name('admin.users.add');
        Route::get('users/getData', [UserController::class, 'getData'])->name('admin.users.getData');
        Route::post('users/save', [UserController::class, 'save'])->name('admin.users.save');
        Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('users/update', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('users/delete', [UserController::class, 'delete'])->name('admin.users.delete');
        Route::get('users/getDetail-{id}', [UserController::class, 'getDetail'])->name('admin.users.getDetail');
        Route::get('users/getUserGroup', [UserController::class, 'getUserGroup'])->name('admin.users.getUserGroup');
        Route::get('users/getEskul', [UserController::class, 'getEskul'])->name('admin.users.getEskul');
        Route::post('users/changeStatus',[UserController::class, 'changeStatus'])->name('admin.users.changeStatus');
        Route::get('users/generateKode',[UserController::class, 'generateKode'])->name('admin.users.generateKode');
        Route::post('users/checkEmail',[UserController::class, 'checkEmail'])->name('admin.users.checkEmail');
        Route::post('users/checkKode',[UserController::class, 'checkKode'])->name('admin.users.checkKode');

        Route::get('users/arsip',[UserController::class, 'arsip'])->name('admin.users.arsip');
        Route::get('users/arsip/getDataArsip',[UserController::class, 'getDataArsip'])->name('admin.users.getDataArsip');
        Route::put('users/arsip/restore',[UserController::class, 'restore'])->name('admin.users.restore');
        Route::delete('users/arsip/forceDelete',[UserController::class, 'forceDelete'])->name('admin.users.forceDelete');
        
        //Profile
        Route::get('profile/{kode}', [ProfileController::class, 'index'])->name('admin.profile');
        Route::get('profile/getData', [ProfileController::class, 'getData'])->name('admin.profile.getData');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::get('profile/getDetail-{kode}', [ProfileController::class, 'getDetail'])->name('admin.profile.getDetail');
        Route::post('profile/checkEmail',[ProfileController::class, 'checkEmail'])->name('admin.profile.checkEmail');
        
        //Setting
        Route::get('settings', [SettingController::class, 'index'])->name('admin.settings');
        Route::put('settings/update', [SettingController::class, 'update'])->name('admin.settings.update');

        //Modul dan Modul Akses
        Route::get('module', [ModuleController::class, 'index'])->name('admin.module');
        Route::get('module/add', [ModuleController::class, 'add'])->name('admin.module.add');
        Route::get('module/getData', [ModuleController::class, 'getData'])->name('admin.module.getData');
        Route::post('module/save', [ModuleController::class, 'save'])->name('admin.module.save');
        Route::get('module/edit/{id}', [ModuleController::class, 'edit'])->name('admin.module.edit');
        Route::put('module/update', [ModuleController::class, 'update'])->name('admin.module.update');
        Route::delete('module/delete', [ModuleController::class, 'delete'])->name('admin.module.delete');
        Route::get('module/getDetail-{id}', [ModuleController::class, 'getDetail'])->name('admin.module.getDetail');
        
        //Jadwal
        Route::get('jadwal', [JadwalController::class, 'index'])->name('admin.jadwal');
        Route::get('jadwal/add', [JadwalController::class, 'add'])->name('admin.jadwal.add');
        Route::get('jadwal/getData', [JadwalController::class, 'getData'])->name('admin.jadwal.getData');
        Route::post('jadwal/save', [JadwalController::class, 'save'])->name('admin.jadwal.save');
        Route::get('jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('admin.jadwal.edit');
        Route::put('jadwal/update', [JadwalController::class, 'update'])->name('admin.jadwal.update');
        Route::delete('jadwal/delete', [JadwalController::class, 'delete'])->name('admin.jadwal.delete');
        Route::post('jadwal/checkHari',[JadwalController::class, 'checkHari'])->name('admin.jadwal.checkHari');
        Route::get('jadwal/getHari', [JadwalController::class, 'getHari'])->name('admin.jadwal.getHari');
        
        //Sekbid
        Route::get('sekbid', [SekbidController::class, 'index'])->name('admin.sekbid');
        Route::get('sekbid/add', [SekbidController::class, 'add'])->name('admin.sekbid.add');
        Route::get('sekbid/getData', [SekbidController::class, 'getData'])->name('admin.sekbid.getData');
        Route::post('sekbid/save', [SekbidController::class, 'save'])->name('admin.sekbid.save');
        Route::get('sekbid/edit/{id}', [SekbidController::class, 'edit'])->name('admin.sekbid.edit');
        Route::put('sekbid/update', [SekbidController::class, 'update'])->name('admin.sekbid.update');
        Route::delete('sekbid/delete', [SekbidController::class, 'delete'])->name('admin.sekbid.delete');
        Route::post('sekbid/checkTingkat',[SekbidController::class, 'checkTingkat'])->name('admin.sekbid.checkTingkat');
        Route::get('sekbid/getDetail-{id}', [SekbidController::class, 'getDetail'])->name('admin.sekbid.getDetail');

        //Ekstrakurikuler
        Route::get('eskul', [EskulController::class, 'index'])->name('admin.eskul');
        Route::get('eskul/add', [EskulController::class, 'add'])->name('admin.eskul.add');
        Route::get('eskul/getData', [EskulController::class, 'getData'])->name('admin.eskul.getData');
        Route::post('eskul/save', [EskulController::class, 'save'])->name('admin.eskul.save');
        Route::get('eskul/edit/{id}', [EskulController::class, 'edit'])->name('admin.eskul.edit');
        Route::put('eskul/update', [EskulController::class, 'update'])->name('admin.eskul.update');
        Route::delete('eskul/delete', [EskulController::class, 'delete'])->name('admin.eskul.delete');
        Route::get('eskul/getDetail-{id}', [EskulController::class, 'getDetail'])->name('admin.eskul.getDetail');
        Route::post('eskul/checkNama',[EskulController::class, 'checkNama'])->name('admin.eskul.checkNama');
        Route::get('eskul/getSekbid', [EskulController::class, 'getSekbid'])->name('admin.eskul.getSekbid');
        Route::get('eskul/getJadwal', [EskulController::class, 'getJadwal'])->name('admin.eskul.getJadwal');

        Route::get('eskul/arsip',[EskulController::class, 'arsip'])->name('admin.eskul.arsip');
        Route::get('eskul/arsip/getDataArsip',[EskulController::class, 'getDataArsip'])->name('admin.eskul.getDataArsip');
        Route::put('eskul/arsip/restore',[EskulController::class, 'restore'])->name('admin.eskul.restore');
        Route::delete('eskul/arsip/forceDelete',[EskulController::class, 'forceDelete'])->name('admin.eskul.forceDelete');

        //Kelas
        Route::get('kelas', [KelasController::class, 'index'])->name('admin.kelas');
        Route::get('kelas/add', [KelasController::class, 'add'])->name('admin.kelas.add');
        Route::get('kelas/getData', [KelasController::class, 'getData'])->name('admin.kelas.getData');
        Route::post('kelas/save', [KelasController::class, 'save'])->name('admin.kelas.save');
        Route::get('kelas/edit/{id}', [KelasController::class, 'edit'])->name('admin.kelas.edit');
        Route::put('kelas/update', [KelasController::class, 'update'])->name('admin.kelas.update');
        Route::delete('kelas/delete', [KelasController::class, 'delete'])->name('admin.kelas.delete');
        Route::post('kelas/checkKelas',[KelasController::class, 'checkKelas'])->name('admin.kelas.checkKelas');
        Route::post('kelas/checkKodeRomawi',[KelasController::class, 'checkKodeRomawi'])->name('admin.kelas.checkKodeRomawi');
        
        //Jurusan
        Route::get('jurusan', [JurusanController::class, 'index'])->name('admin.jurusan');
        Route::get('jurusan/add', [JurusanController::class, 'add'])->name('admin.jurusan.add');
        Route::get('jurusan/getData', [JurusanController::class, 'getData'])->name('admin.jurusan.getData');
        Route::post('jurusan/save', [JurusanController::class, 'save'])->name('admin.jurusan.save');
        Route::get('jurusan/edit/{id}', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
        Route::put('jurusan/update', [JurusanController::class, 'update'])->name('admin.jurusan.update');
        Route::delete('jurusan/delete', [JurusanController::class, 'delete'])->name('admin.jurusan.delete');
        Route::post('jurusan/checkNama',[JurusanController::class, 'checkNama'])->name('admin.jurusan.checkNama');

        //Anggota
        Route::get('anggota', [AnggotaController::class, 'index'])->name('admin.anggota');
        Route::get('anggota/add', [AnggotaController::class, 'add'])->name('admin.anggota.add');
        Route::get('anggota/getData', [AnggotaController::class, 'getData'])->name('admin.anggota.getData');
        Route::post('anggota/save', [AnggotaController::class, 'save'])->name('admin.anggota.save');
        Route::get('anggota/edit/{id}', [AnggotaController::class, 'edit'])->name('admin.anggota.edit');
        Route::put('anggota/update', [AnggotaController::class, 'update'])->name('admin.anggota.update');
        Route::delete('anggota/delete', [AnggotaController::class, 'delete'])->name('admin.anggota.delete');
        Route::get('anggota/getDetail-{id}', [AnggotaController::class, 'getDetail'])->name('admin.anggota.getDetail');
        Route::post('anggota/checkTelepon',[AnggotaController::class, 'checkTelepon'])->name('admin.anggota.checkTelepon');
        Route::post('anggota/checkEmail',[AnggotaController::class, 'checkEmail'])->name('admin.anggota.checkEmail');
        Route::post('anggota/checkNis',[AnggotaController::class, 'checkNis'])->name('admin.anggota.checkNis');
        Route::get('anggota/getEskul', [AnggotaController::class, 'getEskul'])->name('admin.anggota.getEskul');
        Route::get('anggota/getKelas', [AnggotaController::class, 'getKelas'])->name('admin.anggota.getKelas');
        Route::get('anggota/getJurusan', [AnggotaController::class, 'getJurusan'])->name('admin.anggota.getJurusan');
        Route::get('anggota/export', [AnggotaController::class, 'export'])->name('admin.anggota.export');

        //Pendaftaran
        Route::get('pendaftaran', [PendaftaranController::class, 'index'])->name('admin.pendaftaran');
        Route::get('pendaftaran/add', [PendaftaranController::class, 'add'])->name('admin.pendaftaran.add');
        Route::get('pendaftaran/getData', [PendaftaranController::class, 'getData'])->name('admin.pendaftaran.getData');
        Route::post('pendaftaran/save', [PendaftaranController::class, 'save'])->name('admin.pendaftaran.save');
        Route::get('pendaftaran/edit/{id}', [PendaftaranController::class, 'edit'])->name('admin.pendaftaran.edit');
        Route::put('pendaftaran/update', [PendaftaranController::class, 'update'])->name('admin.pendaftaran.update');
        Route::delete('pendaftaran/delete', [PendaftaranController::class, 'delete'])->name('admin.pendaftaran.delete');
        Route::get('pendaftaran/getDetail-{id}', [PendaftaranController::class, 'getDetail'])->name('admin.pendaftaran.getDetail');
        Route::post('pendaftaran/checkTelepon',[PendaftaranController::class, 'checkTelepon'])->name('admin.pendaftaran.checkTelepon');
        Route::post('pendaftaran/checkEmail',[PendaftaranController::class, 'checkEmail'])->name('admin.pendaftaran.checkEmail');
        Route::post('pendaftaran/checkNis',[PendaftaranController::class, 'checkNis'])->name('admin.pendaftaran.checkNis');
        Route::get('pendaftaran/getEskul', [PendaftaranController::class, 'getEskul'])->name('admin.pendaftaran.getEskul');
        Route::get('pendaftaran/getKelas', [PendaftaranController::class, 'getKelas'])->name('admin.pendaftaran.getKelas');
        Route::get('pendaftaran/getJurusan', [PendaftaranController::class, 'getJurusan'])->name('admin.pendaftaran.getJurusan');
        Route::post('pendaftaran/accept', [PendaftaranController::class, 'accept'])->name('admin.pendaftaran.accept');
        Route::delete('pendaftaran/reject', [PendaftaranController::class, 'reject'])->name('admin.pendaftaran.reject');
        Route::get('pendaftaran/export', [PendaftaranController::class, 'export'])->name('admin.pendaftaran.export');

        //Dokumentasi
        Route::get('dokumentasi', [DokumentasiController::class, 'index'])->name('admin.dokumentasi');
        Route::get('dokumentasi/add', [DokumentasiController::class, 'add'])->name('admin.dokumentasi.add');
        Route::get('dokumentasi/getData', [DokumentasiController::class, 'getData'])->name('admin.dokumentasi.getData');
        Route::post('dokumentasi/save', [DokumentasiController::class, 'save'])->name('admin.dokumentasi.save');
        Route::get('dokumentasi/edit/{id}', [DokumentasiController::class, 'edit'])->name('admin.dokumentasi.edit');
        Route::put('dokumentasi/update', [DokumentasiController::class, 'update'])->name('admin.dokumentasi.update');
        Route::delete('dokumentasi/delete', [DokumentasiController::class, 'delete'])->name('admin.dokumentasi.delete');
        Route::get('dokumentasi/getDetail-{id}', [DokumentasiController::class, 'getDetail'])->name('admin.dokumentasi.getDetail');
        Route::get('dokumentasi/getEskul', [DokumentasiController::class, 'getEskul'])->name('admin.dokumentasi.getEskul');

        //Berita
        Route::get('berita', [BeritaController::class, 'index'])->name('admin.berita');
        Route::get('berita/add', [BeritaController::class, 'add'])->name('admin.berita.add');
        Route::get('berita/getData', [BeritaController::class, 'getData'])->name('admin.berita.getData');
        Route::post('berita/save', [BeritaController::class, 'save'])->name('admin.berita.save');
        Route::get('berita/edit/{id}', [BeritaController::class, 'edit'])->name('admin.berita.edit');
        Route::put('berita/update', [BeritaController::class, 'update'])->name('admin.berita.update');
        Route::delete('berita/delete', [BeritaController::class, 'delete'])->name('admin.berita.delete');
        Route::get('berita/getDetail-{id}', [BeritaController::class, 'getDetail'])->name('admin.berita.getDetail');
        Route::get('berita/getEskul', [BeritaController::class, 'getEskul'])->name('admin.berita.getEskul');

        //Setting Page Kepala Sekolah
        Route::get('kepala-sekolah', [KepalaSekolahController::class, 'index'])->name('admin.kepala_sekolah');
        Route::put('kepala-sekolah/update', [KepalaSekolahController::class, 'update'])->name('admin.kepala_sekolah.update');

        //Setting Page Wakil Kepala Sekolah
        Route::get('wakil-kepala-sekolah', [WakilKepalaSekolahController::class, 'index'])->name('admin.wakil_kepala_sekolah');
        Route::put('wakil-kepala-sekolah/update', [WakilKepalaSekolahController::class, 'update'])->name('admin.wakil_kepala_sekolah.update');

        //Setting Status Pendaftaran
        Route::get('setting-pendaftaran', [SettingPendaftaranController::class, 'index'])->name('admin.settingPendaftaran');
        Route::put('setting-pendaftaran/update', [SettingPendaftaranController::class, 'update'])->name('admin.settingPendaftaran.update');
    });
});
