<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventCont;
use App\Http\Controllers\IndexCont;

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

Route::get('/', function () {
    // return view('welcome');
    // return view('layouts.raw');
    return redirect('/agenda-jurnal');
});

Route::get('/agenda-jurnal',[IndexCont::class,'index'])->name('/utama');
Route::post('fullcalendar/create',[EventCont::class, 'create']);
Route::post('fullcalendar/update',[EventCont::class, 'update']);
Route::post('fullcalendar/delete',[EventCont::class, 'delete']);

// new
Route::get('fullcalender', [EventCont::class, 'index']);
Route::post('fullcalenderAjax', [EventCont::class, 'ajax']);

Route::post('/new_input', [EventCont::class,'new_input']);
Route::get('/jurnalku-data',[EventCont::class,'jurnalku']);
Route::post('/new_update', [EventCont::class,'new_update']);
Route::get('/show/{start}', [EventCont::class,'show']);
Route::get('/show-my-job/{anggota_id}/{tanggal}',[EventCont::class,'show_my_job']);

Route::get('/recap-jurnal', [EventCont::class,'recap']);

Route::get('/jurnal-harian',[IndexCont::class,'jurnal_harian']);
Route::post('/autocomplete',[IndexCOnt::class,'fetch'])->name('autocomplete.fetch');

// login
Route::get('/fetch_username_from_bidang/{bidang_id}', [EventCont::class,'get_username_from_bidang']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
