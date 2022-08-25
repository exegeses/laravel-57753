<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = Marca::paginate(6);
        return view('marcas', [ 'marcas'=>$marcas ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('marcaCreate');
    }

    /**
    *  método de validación
     */
    private function validarForm( Request $request )
    {
        $request->validate(
            //[ 'campo'=>'reglas ], [ 'campo.regla'=>'mensaje' ]
            [ 'mkNombre'=>'required|unique:marcas|min:2|max:30' ],
            [
              'mkNombre.required'=>'El campo "Nombre de la marca" es obligatorio.',
              'mkNombre.unique'=>'No puede haber dos marcas con el mismo nombre.',
              'mkNombre.min'=>'El campo "Nombre de la marca" debe tener al menos 2 caractéres.',
              'mkNombre.max'=>'El campo "Nombre de la marca" debe tener 30 caractéres como máximo.'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validación
        $this->validarForm($request);
        //si pasó la validación:
        try {
            // instanciamos
            $Marca = new Marca;
            //asignamos atributos
            $Marca->mkNombre = $request->mkNombre;
            //guardamos en tabla marcas
            $Marca->save();
            return redirect('/marcas')
                    ->with([
                            'mensaje'=>'Marca: '.$request->mkNombre.' agregada correctamente',
                            'css'=>'success'
                            ]);
        }
        catch ( \Throwable $th ){
            //throw $th
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'No se pudo agregar la marca: '.$request->mkNombre,
                    'css'=>'danger'
                ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //obtenemos datos de marca por su id
        //DB::select('SELECT idMarca, mkNombre FROM marcas WHERE idMarca = :idMarca');
        //DB::table('marcas')->where('idMarca', $id)->first();
        $Marca = Marca::find($id);
        return view('marcaEdit', [ 'Marca'=>$Marca ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validación
        $this->validarForm($request);
        try {
            //obtenemos datos de una marca por su id
            $Marca = Marca::find( $request->idMarca );
            //modificación de atributos
            $Marca->mkNombre = $request->mkNombre;
            //guardamos los cambios
            $Marca->save();
            //redirecci´ón con mensaje ok
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'Marca: '.$request->mkNombre.' modificada correctamente',
                    'css'=>'success'
                ]);
        }
        catch ( \Throwable $th ){
            //throw $th
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'No se pudo modificar la marca: '.$request->mkNombre,
                    'css'=>'danger'
                ]);
        }

    }

    public function confirm( $id )
    {
        //obtenemos datos de una marca por su id
        $Marca = Marca::find( $id );

        //si NO hay productos relacionados a esa marca
            //podemos borrar
        return view('marcaDelete', [ 'Marca'=>$Marca ]);


        //si HAY hay productos relacionados a esa marca
            // no podemos borrar

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
