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
Route::get('/region/edit/{id}', function ($id)
{
    //obtener datos de la región
    /* raw SQL
    $region = DB::select('SELECT idRegion, regNombre
                            FROM regiones
                            WHERE idRegion = :id',
                                    [ $id ]
                        );
    */
    $region = DB::table('regiones')
                    ->where('idRegion', $id)->first();
    //retornar vista del form para editar
    return view('regionEdit', [ 'region'=>$region ]);

});
Route::post('/region/update', function ()
{
    //capturamos datos enviados por el form
    $regNombre = request('regNombre');
    $idRegion = request('idRegion');
    /*
    DB::update('UPDATE regiones
                   SET  regNombre = :regNombre
                   WHERE idRegion = :idRegion',
                        [ $regNombre, $idRegion ]
               );*/
    try{
        DB::table('regiones')
                ->where('idRegion', $idRegion)
                ->update( [ 'regNombre'=>$regNombre ] );
        return redirect('/regiones')
            ->with([
                'mensaje'=>'Región: '.$regNombre.' modificada correctamente.',
                'css' => 'success'
            ]);
    }
    catch ( \Throwable  $th ){
        return redirect('/regiones')
            ->with([
                'mensaje'=>'No se pudo modificar la región: '.$regNombre,
                'css'=>'danger'
            ]);
    }
});
Route::get('/region/delete/{id}', function ($id)
{
    $cantidad = DB::table('destinos')
                    ->where('idRegion', $id)->count();
    return view('regionDelete', [ 'cantidad'=>$cantidad ]);
});
