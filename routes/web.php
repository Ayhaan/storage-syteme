<?php

use App\Http\Controllers\FileController;
use App\Models\File;
use Illuminate\Support\Facades\Route;

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
    $files = File::all();
    return view('home', compact('files'));
})->name('home');


Route::post('/file/store', [FileController::class, 'store'])->name('file.store');
Route::post('/fileurl/store', [FileController::class, 'storeUrl'])->name('file-url.store');
Route::delete("file/{file}/delete", [FileController::class, "destroy"])->name('file.destroy');


Route::put('/file/{file}/store', [FileController::class, 'update'])->name('file.update');
Route::get('/file/{file}/download', [FileController::class, "download"])->name('file.download');