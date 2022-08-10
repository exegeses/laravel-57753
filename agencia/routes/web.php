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

Route::get('/inicio', function ()
{
    return view('inicio');
});

########################
## CRUD de regiones
Route::get('/regiones', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::select('SELECT idRegion, regNombre
                                FROM regiones');
    return view('regiones', [ 'regiones'=>$regiones ]);
});
Route::get('/region/create', function ()
{
    return view('regionCreate');
});
Route::post('/region/store', function ()
{
    //captuamos dato enviado por el form
    $regNombre = request('regNombre');
    //insertar dato en tabla regiones

    try {
        DB::insert('INSERT INTO regiones
                            ( regNombre )
                        VALUES
                            ( :regNombre )',
                            [ $regNombre ]
                    );
        return redirect('/regiones')
                ->with([
                        'mensaje'=>'Región: '.$regNombre.' agregada correctamente.',
                        'css' => 'success'
                       ]);
    }
    catch ( \Throwable  $th ){
        return redirect('/regiones')
                ->with([
                        'mensaje'=>'No se pudo agregar la región: '.$regNombre,
                        'css'=>'danger'
                       ]);
    }

});
