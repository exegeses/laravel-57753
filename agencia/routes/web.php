<?php

use Illuminate\Support\Facades\Route;

//Route::metodo( '/peticion', acción )
Route::get('/', function () {
    return view('welcome');
});

//Route::get('/peticion', accion);
Route::get('/rojo', function ()
{
    return view('welcome');
});

Route::get('/form', function ()
{
    return view('form');
});
Route::post('/procesa', function ()
{
    //capturamos dato enviado por el form
    //$nombre = $_POST['nombre'];
    //$nombre = request()->input('nombre');
    $nombre = request('nombre');
    //creamos un array de marcas
    $marcas = [ 'samsung', 'audiotecnica', 'boss', 'senheisser', 'apple', 'asus' ];

    //pasamos variable/s a la ruta
    return view('procesa',
                [
                    'nombre'=>$nombre,
                    'marcas'=>$marcas
                ]
            );
});

/* Traemos datos desde MySQL */
Route::get('/listaRegiones', function ()
{
    $regiones = DB::select('SELECT idRegion, regNombre
                            FROM regiones');
    return view('listaRegiones', [ 'regiones'=>$regiones ]);
});


