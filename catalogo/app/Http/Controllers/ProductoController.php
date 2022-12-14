<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with(['getMarca', 'getCategoria'])->paginate(5);
        return view('productos', [ 'productos'=>$productos ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //obtenemos listados de marcas y categorías
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoCreate',
                    [
                        'marcas'=>$marcas,
                        'categorias'=>$categorias
                    ]
                    );
    }

    private function validarForm( Request $request )
    {
        $request->validate(
            [
                'prdNombre'=>'required|min:2|max:30',
                'prdPrecio'=>'required|numeric|min:0',
                'idMarca'=>'required',
                'idCategoria'=>'required',
                'prdDescripcion'=>'required|min:3|max:150',
                'prdImagen'=>'mimes:png,jpg,jpeg,webp,svg,gif|max:2048'
            ],
            [
                'prdNombre.required' => 'El campo "Nombre del producto" es obligatorio.',
                'prdNombre.min'=>'El campo "Nombre del producto" debe tener como mínimo 2 caractéres.',
                'prdNombre.max'=>'El campo "Nombre" debe tener 30 caractéres como máximo.',
                'prdNombre.required' => 'El campo "Nombre del producto" es obligatorio.',
                'prdNombre.min'=>'El campo "Nombre del producto" debe tener como mínimo 2 caractéres.',
                'prdNombre.max'=>'El campo "Nombre" debe tener 30 caractéres como máximo.',
                'prdPrecio.required'=>'Complete el campo Precio.',
                'prdPrecio.numeric'=>'Complete el campo Precio con un número.',
                'prdPrecio.min'=>'Complete el campo Precio con un número mayor a 0.',
                'idMarca.required'=>'Seleccione una marca.',
                'idCategoria.required'=>'Seleccione una categoría.',
                'prdDescripcion.required'=>'Complete el campo Descripción.',
                'prdDescripcion.min'=>'Complete el campo Descripción con al menos 3 caractéres',
                'prdDescripcion.max'=>'Complete el campo Descripción con 150 caractéres como máxino.',
                'prdImagen.mimes'=>'Debe ser una imagen.',
                'prdImagen.max'=>'Debe ser una imagen de 2MB como máximo.'
            ]
        );
    }

    private function subirImagen( Request $request ) : string
    {
        //si no enviaron imagen > 'noDisponible.png' en AGREGAR
        $prdImagen = 'noDisponible.png';

        //si no enviaron imagen en MODIFICAR
        if( $request->has('imgActual') ){
            $prdImagen = $request->imgActual;
        }

        //si enviaron imagen
        if( $request->file('prdImagen') ){
            $archivo = $request->file('prdImagen');
            //renombramos archivo :  167675876.ext
                // time().'.'.'jpg';
            $ext = $archivo->getClientOriginalExtension();
            $prdImagen = time().'.'.$ext;
            //movemos el archivo
            $archivo->move( public_path('imagenes/productos/'), $prdImagen );
        }

        return $prdImagen;
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
        $this->validarForm( $request );
        //subir archivo
        $prdImagen = $this->subirImagen($request);
        try {
            //magia para dar de alta
            $Producto = new Producto;
            $Producto->prdNombre = $request->prdNombre;
            $Producto->prdPrecio = $request->prdPrecio;
            $Producto->idMarca = $request->idMarca;
            $Producto->idCategoria = $request->idCategoria;
            $Producto->prdDescripcion = $request->prdDescripcion;
            $Producto->prdImagen = $prdImagen;
            $Producto->prdActivo = 1;
            //guardamos
            $Producto->save();
            //mensaje
            //redirecci´ón con mensaje ok
            return redirect('/productos')
                ->with([
                    'mensaje'=>'Producto: '.$request->prdNombre.' agregado correctamente',
                    'css'=>'success'
                ]);
        }
        catch ( \Throwable $th ){
            //throw $th
            return redirect('/productos')
                ->with([
                    'mensaje'=>'No se pudo agregar el producto: '.$request->prdNombre,
                    'css'=>'danger'
                ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //obtenemos datos del producto
        $Producto = Producto::find($id);
        //obtenemos listados de marcas y categorias
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoEdit',
                [
                    'Producto' => $Producto,
                    'marcas' => $marcas,
                    'categorias' => $categorias
                ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request)
    {
        //validación
        $this->validarForm( $request );
        //subir imagen
        $prdImagen = $this->subirImagen( $request );

        try {
            //magia para modificar
            $Producto = Producto::find( $request->idProducto );
            $Producto->prdNombre = $request->prdNombre;
            $Producto->prdPrecio = $request->prdPrecio;
            $Producto->idMarca = $request->idMarca;
            $Producto->idCategoria = $request->idCategoria;
            $Producto->prdDescripcion = $request->prdDescripcion;
            $Producto->prdImagen = $prdImagen;
            $Producto->prdActivo = 1;
            //guardamos
            $Producto->save();
            //mensaje
            //redirecci´ón con mensaje ok
            return redirect('/productos')
                ->with([
                    'mensaje'=>'Producto: '.$request->prdNombre.' modificado correctamente',
                    'css'=>'success'
                ]);
        }
        catch ( \Throwable $th ){
            //throw $th
            return redirect('/productos')
                ->with([
                    'mensaje'=>'No se pudo modificar el producto: '.$request->prdNombre,
                    'css'=>'danger'
                ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
