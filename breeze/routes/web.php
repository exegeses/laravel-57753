<?php

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/marcas', function ()
{
    return view('marcas');
})->middleware(['auth'])->name('marcas');

Route::get('/categorias', function ()
{
    return view('categorias');
})->middleware(['auth'])->name('categorias');


/* ruta sin usaar las vistas de breeze */
Route::get('/testAuth', function ()
{
    return view('vistaTest');
})->middleware(['auth']);



require __DIR__.'/auth.php';
