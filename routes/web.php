<?php

use App\Models\RoleMenu;
use App\Mail\VerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DataProdukController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TransaksiDetailAditional;
use App\Http\Controllers\TransaksiDetailController;
use App\Http\Controllers\AksesCabangController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DataPelajaranController;
use App\Http\Controllers\DataSiswaController;
use App\Http\Controllers\DataTokoController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\PelajaranKelasController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SekolahController;
use App\Models\TransaksiDetail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/admin/dashboard', function () {
//     return view('dashboard');
// });
Route::get('/admin/dashboard2', function () {
    return view('admin/dashboard2');
});
Route::get('/admin/dashboard3', function () {
    return view('admin/dashboard3');
});

Route::get('/admin/user', function () {
    return view('admin/user');
});

Route::get('/admin/transaksi/modal', function () {
    return view('transaksi/modal');
});

// Route::get('menu.update', function () {
//     return view('menu/update');
// });




Auth::routes();

Auth::routes([
    'verify' =>true
]);
Route::get('logout', [LoginController::class, 'logout']);
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('Adminlogin');
Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('Adminregister');
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');
Route::get('logout', [LoginController::class, 'showRegisterForm']);
Route::get('/admin/user', [App\Http\Controllers\MenuController::class, 'user'])->name('user');
Route::get('/admin/role', [App\Http\Controllers\MenuController::class, 'role'])->name('role');
Route::get('/admin/user', function () {
    return view('user');
});

Route::get('/admin/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu/store', [MenuController::class, 'store']);
Route::get('/admin/menu', [MenuController::class,'index'])->name('menu.index');
Route::get('/admin/menu/destroy/{id}', [MenuController::class,'destroy'])->name('menu.destroy');
Route::get('/admin/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/admin/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');

// role
Route::put('/admin/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
Route::get('/admin/role/create', [RoleController::class, 'create'])->name('role.create');
Route::get('/admin/role', [RoleController::class,'index'])->name('role.index');
Route::get('/admin/role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::post('/role/store', [RoleController::class, 'store']);
Route::get('/admin/role/destroy/{id}', [RoleController::class,'destroy'])->name('role.destroy');

// user
Route::put('/admin/user/update/{id}', [DataUserController::class, 'update'])->name('user.update');
Route::get('/admin/user/create', [DataUserController::class, 'create'])->name('user.create');
Route::get('/admin/user', [DataUserController::class,'index'])->name('user.index');
Route::get('/admin/user/edit/{id}', [DataUserController::class, 'edit'])->name('user.edit');
Route::post('/user/store', [DataUserController::class, 'store']);
Route::get('/admin/user/destroy/{id}', [DataUserController::class,'destroy'])->name('user.destroy');

// edit profil
Route::middleware(['auth'])->group(function () {
    Route::get('/profil/edit', [DataUserController::class, 'editProfil'])->name('profil.edit');
    Route::put('/profil/update', [DataUserController::class, 'updateProfil'])->name('profil.update');
});


// edit password
Route::middleware(['auth'])->group(function () {
    Route::get('/password/edit', [DataUserController::class, 'editPassword'])->name('password.edit');
    Route::put('/password/update', [DataUserController::class, 'updatePassword'])->name('password.update');
});


// sidebar
Route::get('/sidebar2', [MenuController::class,'getSidebar'])->name('sidebar'); // Ganti dengan controller dan rute yang relevan

// data sekolah
Route::put('/admin/sekolah/update/{id}', [SekolahController::class, 'update'])->name('sekolah.update');
Route::get('/admin/sekolah/create', [SekolahController::class, 'create'])->name('sekolah.create');
Route::get('/admin/sekolah', [SekolahController::class,'index'])->name('sekolah.index');
Route::get('/admin/sekolah/edit/{id}', [SekolahController::class, 'edit'])->name('sekolah.edit');
Route::post('/sekolah/store', [SekolahController::class, 'store']);
Route::get('/admin/sekolah/destroy/{id}', [SekolahController::class,'destroy'])->name('sekolah.destroy');

// data kelas
Route::put('/admin/kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
Route::get('/admin/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
Route::get('/admin/kelas', [KelasController::class,'index'])->name('kelas.index');
Route::get('/admin/kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
Route::post('/kelas/store', [KelasController::class, 'store']);
Route::get('/admin/kelas/destroy/{id}', [KelasController::class,'destroy'])->name('kelas.destroy');

// data mata pelajaran
Route::put('/admin/mapel/update/{id}', [DataPelajaranController::class, 'update'])->name('mapel.update');
Route::get('/admin/mapel/create', [DataPelajaranController::class, 'create'])->name('mapel.create');
Route::get('/admin/mapel', [DataPelajaranController::class,'index'])->name('mapel.index');
Route::get('/admin/mapel/edit/{id}', [DataPelajaranController::class, 'edit'])->name('mapel.edit');
Route::post('/mapel/store', [DataPelajaranController::class, 'store']);
Route::get('/admin/mapel/destroy/{id}', [DataPelajaranController::class,'destroy'])->name('mapel.destroy');


// data mata pelajaran perkelas
Route::put('/admin/mapelKelas/update/{id}', [PelajaranKelasController::class, 'update'])->name('mapelKelas.update');
Route::get('/admin/mapelKelas/create', [PelajaranKelasController::class, 'create'])->name('mapelKelas.create');
Route::get('/admin/mapelKelas', [PelajaranKelasController::class,'index'])->name('mapelKelas.index');
Route::get('/admin/mapelKelas/edit/{id}', [PelajaranKelasController::class, 'edit'])->name('mapelKelas.edit');
Route::post('/mapelKelas/store', [PelajaranKelasController::class, 'store']);
Route::get('/admin/mapelKelas/destroy/{id}', [PelajaranKelasController::class,'destroy'])->name('mapelKelas.destroy');

// filter berdasarkan sekolah
// Route::get('/get-data-by-sekolah', [PelajaranKelasController::class,'create']);
// Route::get('/get-options-by-sekolah', [PelajaranKelasController::class,'getOptionsBySekolah']);


// data siswa
Route::put('/admin/siswa/update/{id}', [DataSiswaController::class, 'update'])->name('siswa.update');
Route::get('/admin/siswa/create', [DataSiswaController::class, 'create'])->name('siswa.create');
Route::get('/admin/siswa', [DataSiswaController::class,'index'])->name('siswa.index');
Route::get('/admin/siswa/edit/{id}', [DataSiswaController::class, 'edit'])->name('siswa.edit');
Route::post('/siswa/store', [DataSiswaController::class, 'store']);
Route::get('/admin/siswa/destroy/{id}', [DataSiswaController::class,'destroy'])->name('siswa.destroy');

