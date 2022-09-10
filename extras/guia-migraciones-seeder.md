# Guia para crear Models, Migrations, Controllers y Seeders

- [ ] pasos:

## Crear tablas
> crear migracion(es)  
    php artisan make:migration  nombre  

> correr migracion(es)  
    php artisan migrate

## Crear Models
> crear Model(s) *  
    php artisan make:model Nombre

## Insertar datos  
> crear seeder(s)  
    php artisan make:seeder NombreSeeder

> correr seeder(s)  
    php artisan db:seed  *  

    php artisan db:seed --class=NombreSeed 

> crear Controllers  
    php artisan make:controller NombreController -r


*** en 1 paso ***
> crear Model + Controller + migration + seeder

        php artisan make:model Nombre -mcrs




