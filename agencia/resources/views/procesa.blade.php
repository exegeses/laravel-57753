<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulario</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
    <header class="py-5 bg-dark">
        <nav class="text-white container">
            menu
        </nav>
    </header>
    <main class="container py-3">
        <h1>Proceso de datos enviados</h1>

        <div class="alert shadow col-8 mx-auto">
            fecha: {{ date('d/m/Y H:i:s') }} <br>

            @if( $nombre == 'marcos' )
                bienvenido {{ $nombre }}
            @else
                bienvenido invitado
            @endif
        </div>

        <div class="alert shadow col-8 mx-auto">
            bienvenido {{ ( $nombre == 'marcos' ) ? $nombre : 'invitado' }}
        </div>

        <div class="alert shadow col-8 mx-auto">
            <ul>
            @foreach( $marcas as $marca )
                <li>{{ $marca }}</li>
            @endforeach
            </ul>
        </div>



    </main>
    <footer class="fixed-bottom bg-light text-center py-5">
        leyenda de copyright
    </footer>
</body>
</html>
