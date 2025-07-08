<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Route;

Route::get('/users/datatable', [UserControler::class, 'index'])->name('users.index');

Route::get('/', function () {
    return view('tailwind');
});
Route::get('/bootstrap', function () {
    return view('bootstrap');
});
Route::get('/alpine', function () {
    return view('alpine');
});
Route::get('/plainjs', function () {
    return view('plainjs');
});
