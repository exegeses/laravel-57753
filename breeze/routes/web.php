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

#################################################################
######## CRUD de marcas
use App\Http\Controllers\MarcaController;
Route::get('/marcas', [ MarcaController::class, 'index' ])
    ->middleware(['auth'])->name('marcas');
Route::get('/marca/create', [ MarcaController::class, 'create' ])
    ->middleware(['auth']);
Route::post('/marca/store', [ MarcaController::class, 'store' ])
    ->middleware(['auth']);
Route::get('/marca/edit/{id}', [ MarcaController::class, 'edit' ])
    ->middleware(['auth']);
Route::put('/marca/update', [ MarcaController::class, 'update' ])
    ->middleware(['auth']);
Route::get('/marca/confirm/{id}', [ MarcaController::class, 'confirm' ])
    ->middleware(['auth']);
Route::delete('/marca/delete', [ MarcaController::class, 'destroy' ])
    ->middleware(['auth']);

#################################################################
######## CRUD de categorías
Route::get('/categorias', function ()
{
    return view('categorias');
})->middleware(['auth'])->name('categorias');


#################################################################
######## CRUD de productos
use App\Http\Controllers\ProductoController;
Route::get('/productos', [ ProductoController::class, 'index' ])
    ->middleware(['auth'])->name('productos');



/* ruta sin usaar las vistas de breeze */
Route::get('/testAuth', function ()
{
    return view('vistaTest');
})->middleware(['auth']);



require __DIR__.'/auth.php';
