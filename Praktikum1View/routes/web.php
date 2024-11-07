<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/mahasiswa', function () {
    return view('dashboard');
});

Route::get('/mahasiswa/list', function () {
    $mahasiswa = [
        ['nama' => 'Rahmat', 'nim' => '19151010503'],
        ['nama' => 'eko', 'nim' => '19151010505'],
        ['nama' => 'wow', 'nim' => '19151010502'],
    ];
    return view('mahasiswa.index', compact('mahasiswa'));
});