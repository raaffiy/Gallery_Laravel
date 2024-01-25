<?php

use App\Models\Image;
use Illuminate\Support\Facades\Route;

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
    $images = Image::all(); // Ambil semua data gambar dari database

    return view('index', ['images' => $images]);
});
Route::get('/gallery-single/{id}', function($id) {
    $image = Image::find($id);

    return view('gallery-single', ['image' => $image]);
})->name('gallery.single');
