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
        //obtenemos listado de marcas
        $marcas = Marca::all();
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

    private function validarForm( Request $request )
    {
        $request->validate(
            ['mkNombre'=>'required|unique:marcas|min:2|max:30'],
            ['mkNombre.required'=>'El campo "Nombre de la marca" es obligratorio',
                'mkNombre.unique'=>'No puede haber dos marcas con el mismo nombre',
                'mkNombre.min'=>'El campo "Nombre de la marca" no puede tener menos de 2 caractéres',
                'mkNombre.max'=>'El campo "Nombre de la marca" no puede tener mas de 30 caractéres']
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
        try {
            //instanciamos, asignamos atributos y guardamos
            $Marca = new Marca;
            $Marca->mkNombre = $mkNombre = $request->mkNombre;
            $Marca->save();
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'Marca: '.$mkNombre.' agregada correctamente',
                    'css'=>'green'
                ]);
        }
        catch ( \Throwable $th ){
            //throw $th
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'No se pudo agregar la marca: '.$request->mkNombre,
                    'css'=>'red'
                ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        $Marca = Marca::find($id);
        return view('marcaEdit', [ 'Marca'=>$Marca ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //validación
        $this->validarForm($request);
        $mkNombre = $request->mkNombre;
        try {
            $Marca = Marca::find( $request->idMarca );
            $Marca->mkNombre = $mkNombre;
            $Marca->save();
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'Marca: '.$mkNombre.' agregada correctamente',
                    'css'=>'green'
                ]);
        }
        catch ( \Throwable $th ){
            //throw $th
            return redirect('/marcas')
                ->with([
                    'mensaje'=>'No se pudo modificar la marca: '.$mkNombre,
                    'css'=>'red'
                ]);
        }
    }

    public function confirm($id)
    {

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marca $marca)
    {
        //
    }
}
