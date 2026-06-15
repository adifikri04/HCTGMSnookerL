<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('index'); });
Route::get('/admin', function () { return view('admin'); });
Route::get('/book', function () { return view('book'); });
Route::get('/faq', function () { return view('faq'); });
Route::get('/livescores', function () { return view('livescores'); });
Route::get('/login', function () { return view('login'); });
Route::get('/players', function () { return view('players'); });
Route::get('/profile', function () { return view('profile'); });
Route::get('/rankings', function () { return view('rankings'); });
Route::get('/shop', function () { return view('shop'); });
Route::get('/signup', function () { return view('signup'); });
Route::get('/tournaments', function () { return view('tournaments'); });
