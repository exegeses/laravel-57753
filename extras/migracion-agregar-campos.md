# Agregar campos en una table

## caso 1: al final de los campos existentes

> crear una migraci´ón nueva  

    php artisan make migration   alter_paises_add_column

> editar la migración y el método up() quesa así: 

        public function up()
    {
        Schema::table('paises', function (Blueprint $table) {
            $table->tinyInteger('idRegion');
        });
    }

> ejecutar la migración  

    php artisan migrate


> una vez ejecutada la migración. se agrega el campo SIEMPRE al final de los campos existentes.

## caso 2: después de un campo existentes  

> crear una migraci´ón nueva

    php artisan make migration   alter_paises_add_column_after  

> editar la migración y el método up() quesa así:  

        public function up()
    {
        Schema::table('paises', function (Blueprint $table) {
            $table->after('nombre', function ($table) {
                $table->string('idioma', 25);
                $table->string('bandera', 25);
            });

        });
    }


> ejecutar la migración

    php artisan migrate


> una vez ejecutada la migración. se agregan los campos DESPUÉS del campos existentes seleccionado.  


