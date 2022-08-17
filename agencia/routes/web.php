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
    $region = DB::table('regiones')
                    ->where('idRegion',$id)->first();
    return view('regionDelete',
                        [
                            'cantidad'=>$cantidad,
                            'region'=>$region
                        ]);
});
Route::post('/region/destroy', function ()
{
    $idRegion = request('idRegion');
    $regNombre = request('regNombre');
    try {
        DB::table('regiones')
            ->where('idRegion', $idRegion)
            ->delete();
        return redirect('/regiones')
            ->with([
                'mensaje'=>'Región: '.$regNombre.' eliminada correctamente.',
                'css' => 'success'
            ]);
    }
    catch ( \Throwable  $th ){
            //throw $th;
            return redirect('/regiones')
                ->with([
                    'mensaje'=>'No se pudo eliminar la región: '.$regNombre,
                    'css'=>'danger'
                ]);
    }

});

########################
## CRUD de destinos
Route::get('/destinos', function ()
{
    //obtenemos listado de destinos
    /*
     * $destinos = DB::select("SELECT idDestino, destNombre,
                                   regNombre, destPrecio,
                                   destAsientos, destDisponibles
                                FROM destinos as d
                                    JOIN regiones as r on r.idRegion = d.idRegion")
     * */
    $destinos = DB::table('destinos as d')
                    ->join('regiones as r',
                            'r.idRegion', '=', 'd.idRegion')
                        ->get();
    //retornamos vista
    return view('destinos', [ 'destinos'=>$destinos ]);
});
Route::get('/destino/create', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::table('regiones')->get();
    return view('destinoCreate', [ 'regiones'=>$regiones ]);
});
Route::post('/destino/store', function ()
{
    $destNombre = request()->destNombre;
    $idRegion = request()->idRegion;
    $destPrecio = request()->destPrecio;
    $destAsientos = request()->destAsientos;
    $destDisponibles = request()->destDisponibles;
    /* Raw SQL
    DB::insert('
            INSERT INTO destinos
                ( destNombre, idRegion, destPrecio, destAsientos, destDisponibles )
              VALUES
                ( :destNombre, :idRegion, :destPrecio, :destAsientos, :destDisponibles )',
                [ $destNombre, $idRegion, $destPrecio, $destAsientos, $destDisponibles ]);
    */
    try {
        DB::table('destinos')
                ->insert(
                    [
                        'destNombre'=>$destNombre,
                        'idRegion'=>$idRegion,
                        'destPrecio'=>$destPrecio,
                        'destAsientos'=>$destAsientos,
                        'destDisponibles'=>$destDisponibles
                    ]
                );
        return redirect('/destinos')
            ->with([
                'mensaje'=>'Destino: '.$destNombre.' agregado correctamente',
                'css'=>'success'
            ]);
    }
    catch ( \Throwable  $th ){
            //throw $th;
            return redirect('/destinos')
                ->with([
                    'mensaje'=>'No se pudo agregar el destino: '.$destNombre,
                    'css'=>'danger'
                ]);
        }
});
Route::get('/destino/edit/{id}', function ( $id )
{
    $destino = DB::table('destinos')
                ->where('idDestino', $id)->first();
    $regiones = DB::table('regiones')->get();
    return view('destinoEdit',
                    [
                        'destino'=>$destino,
                        'regiones'=>$regiones
                    ]
            );
});
Route::post('/destino/update', function ()
{
    $destNombre = request()->destNombre;
    $idRegion = request()->idRegion;
    $destPrecio = request()->destPrecio;
    $destAsientos = request()->destAsientos;
    $destDisponibles = request()->destDisponibles;
    $idDestino = request()->idDestino;
    try {
        DB::table('destinos')
            ->where('idDestino', $idDestino)
            ->update(
                [
                    'destNombre'=>$destNombre,
                    'idRegion'=>$idRegion,
                    'destPrecio'=>$destPrecio,
                    'destAsientos'=>$destAsientos,
                    'destDisponibles'=>$destDisponibles
                ]
            );
        return redirect('/destinos')
            ->with([
                'mensaje'=>'Destino: '.$destNombre.' modificado correctamente',
                'css'=>'success'
            ]);
    }
    catch ( \Throwable  $th ){
            //throw $th;
            return redirect('/destinos')
                ->with([
                    'mensaje'=>'No se pudo modificar el destino: '.$destNombre,
                    'css'=>'danger'
                ]);
        }
});
Route::get('/destino/delete/{id}', function ($id)
{
    $destino = DB::table('destinos as d')
        ->join('regiones as r', 'r.idRegion', '=', 'd.idRegion')
        ->where('idDestino', $id)->first();
    return view('destinoDelete', [ 'destino'=>$destino ]);
});
Route::post('/destino/destroy', function ()
{
    $destNombre = request()->destNombre;
    $idDestino = request()->idDestino;
    try {
        DB::table('destinos')
                ->where('idDestino', $idDestino)
                ->delete();
        return redirect('/destinos')
            ->with([
                'mensaje'=>'Destino: '.$destNombre.' eliminado correctamente',
                'css'=>'success'
            ]);
    }
    catch ( \Throwable  $th ){
        //throw $th;
        return redirect('/destinos')
            ->with([
                'mensaje'=>'No se pudo eliminar el destino: '.$destNombre,
                'css'=>'danger'
            ]);
    }
});
