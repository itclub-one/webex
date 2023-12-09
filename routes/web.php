<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\landingController;
use App\Http\Controllers\admin\viewController;
use App\Http\Controllers\frontpage\HomeController;
use App\Http\Controllers\frontpage\EskulController;
use App\Http\Controllers\frontpage\BeritaController;
use App\Http\Controllers\frontpage\TentangWebController;
use App\Http\Controllers\frontpage\DokumentasiController;
use App\Http\Controllers\frontpage\PendaftaranController;
use App\Http\Controllers\frontpage\KepalaSekolahController;
use App\Http\Controllers\frontpage\SejarahVisiMisiController;
use App\Http\Controllers\frontpage\WakilKepalaSekolahController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Home
Route::get('/', [HomeController::class, 'index'])->name('web');
Route::get('/getSekbid', [HomeController::class, 'getSekbid'])->name('web.getSekbid');
Route::get('/getEskul', [HomeController::class, 'getEskul'])->name('web.getEskul');
Route::get('/getDokumentasi', [HomeController::class, 'getDokumentasi'])->name('web.getDokumentasi');
Route::get('/getBerita', [HomeController::class, 'getBerita'])->name('web.getBerita');
Route::get('/getKelas', [HomeController::class, 'getKelas'])->name('web.getKelas');
Route::get('/getJurusan', [HomeController::class, 'getJurusan'])->name('web.getJurusan');

//Ekstrakurikuler
Route::get('/ekstrakurikuler', [EskulController::class, 'index'])->name('web.ekstrakurikuler');
Route::get('/ekstrakurikuler/getDataAnggota', [EskulController::class, 'getDataAnggota'])->name('web.ekstrakurikuler.getDataAnggota');
Route::get('/ekstrakurikuler/fetchData', [EskulController::class, 'fetchData'])->name('web.ekstrakurikuler.fetchData');
Route::get('/ekstrakurikuler/fetchDataDokumentasi/{slug}', [EskulController::class, 'fetchDataDokumentasi'])->name('web.ekstrakurikuler.fetchDataDokumentasi');
Route::get('/ekstrakurikuler/getEskulBySlug', [EskulController::class, 'getEskulBySlug'])->name('web.ekstrakurikuler.getEskulBySlug');
Route::get('/ekstrakurikuler/{slug}', [EskulController::class, 'showBySlug'])->name('web.ekstrakurikuler.showBySlug');

//Dokumentasi
Route::get('/dokumentasi', [DokumentasiController::class, 'index'])->name('web.dokumentasi');
Route::get('/dokumentasi/fetchData', [DokumentasiController::class, 'fetchData'])->name('web.dokumentasi.fetchData');
Route::get('/dokumentasi/{eskul}', [DokumentasiController::class, 'showByEskul'])->name('web.dokumentasi.showByEskul');
Route::get('/dokumentasi/{eskul}/{slug}', [DokumentasiController::class, 'showByEskulAndSlug'])->name('web.dokumentasi.showByEskulAndSlug');

//Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('web.berita');
Route::get('/berita/fetchData', [BeritaController::class, 'fetchData'])->name('web.berita.fetchData');
Route::get('/berita/{eskul}', [BeritaController::class, 'showByEskul'])->name('web.berita.showByEskul');
Route::get('/berita/{eskul}/{slug}', [BeritaController::class, 'showByEskulAndSlug'])->name('web.berita.showByEskulAndSlug');

//Pendaftaran
Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('web.pendaftaran');
Route::post('/pendaftaran/save', [PendaftaranController::class, 'save'])->name('web.pendaftaran.save');
Route::post('/pendaftaran/checkTelepon',[PendaftaranController::class, 'checkTelepon'])->name('web.pendaftaran.checkTelepon');
Route::post('/pendaftaran/checkEmail',[PendaftaranController::class, 'checkEmail'])->name('web.pendaftaran.checkEmail');
Route::post('/pendaftaran/checkNis',[PendaftaranController::class, 'checkNis'])->name('web.pendaftaran.checkNis');

//Kepala Sekolah
Route::get('/kepala-sekolah', [KepalaSekolahController::class, 'index'])->name('web.kepalaSekolah');

//Wakil Kepala Sekolah
Route::get('/wakil-kepala-sekolah', [WakilKepalaSekolahController::class, 'index'])->name('web.wakilKepalaSekolah');

//Sejarah Visi dan Misi
Route::get('/sejarah-visi-misi', [SejarahVisiMisiController::class, 'index'])->name('web.sejarahVisiMisi');

//Tentang Web
Route::get('/tentang-web', [TentangWebController::class, 'index'])->name('web.tentangWeb');