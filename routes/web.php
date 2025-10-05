<?php

use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Route;

Route::get('/users/datatable', [UserControler::class, 'index'])->name('users.index');
Route::post('/users', [UserControler::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserControler::class, 'show'])->name('users.show');
Route::put('/users/{id}', [UserControler::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserControler::class, 'destroy'])->name('users.destroy');

Route::get('/', function () {
    return view('tailwind');
});
Route::get('/bootstrap', function () {
    return view('bootstrap');
});
Route::get('/alpine', function () {
    return view('alpine');
});
