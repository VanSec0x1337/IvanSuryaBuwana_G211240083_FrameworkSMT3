<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\LoginController;

// Login routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
});

// Public pages and guest entry/exit
Route::get('/', function () {
    return redirect('perpus');
})->name('root');

Route::get('/perpus', function () {
    return view('ftik');
})->name('perpus');

// Allow guests to view lists (read-only). CRUD routes remain protected below.
Route::get('/buku', [BukuController::class, 'index']);
Route::get('/pinjam', [PinjamController::class, 'index']);
Route::get('/anggota', [AnggotaController::class, 'index']);

// Guest entry: set a session flag so views can render read-only UI
Route::post('/guest', function (Request $request) {
    $request->session()->put('guest', true);
    return redirect('/perpus');
})->name('guest.enter');

// Exit guest: clear the session flag and redirect to login
Route::post('/guest/exit', function (Request $request) {
    $request->session()->forget('guest');
    return redirect('/login');
})->name('guest.exit');

// Protected routes (auth required)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/info', function () {
        return view('info', ['progdi' => 'TI']);
    });

    Route::get('/info/{kd}', [InfoController::class, 'infoMhs']);

    // Rute menggunakan BukuController (write actions)
    Route::get('/buku/add', [BukuController::class, 'add_new']);
    Route::post('/buku/save', [BukuController::class, 'save']);
    Route::get('/buku/edit/{id}', [BukuController::class, 'edit']);
    Route::get('/buku/delete/{id}', [BukuController::class, 'delete']);

    Route::get('/pinjam/add', [PinjamController::class, 'add_new']);
    Route::post('/pinjam/save', [PinjamController::class, 'save']);
    Route::get('/pinjam/delete/{id}', [PinjamController::class, 'delete']);
    Route::get('/pinjam/kembali/{id}', [PinjamController::class, 'kembali']);
    Route::get('/pinjam/edit/{id}', [PinjamController::class, 'edit']);
    Route::post('/pinjam/update', [PinjamController::class, 'update']);

    // Rute anggota (write actions)
    Route::get('/anggota/add', [AnggotaController::class, 'add_new']);
    Route::post('/anggota/save', [AnggotaController::class, 'save']);
    Route::get('/anggota/edit/{id}', [AnggotaController::class, 'edit']);
    Route::post('/anggota/update', [AnggotaController::class, 'update']);
    Route::get('/anggota/delete/{id}', [AnggotaController::class, 'delete']);
});
