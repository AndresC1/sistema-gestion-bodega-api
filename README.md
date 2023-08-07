
<p align="center">

# Sistema de gestion de bodega  ![Status badge](https://img.shields.io/badge/status-in%20progress-yellow) ![Status badge](https://img.shields.io/packagist/l/laravel/framework)
</p>

## 🛠 Requerimientos
- PHP 8.1^
- Composer 2.3.10^
- MySQL

## 🚀 Instalación

1. Clonar proyecto.

2. Instalacion de las dependencias.
```bash
composer install
```

3. Copiar archivo **.env.exmaple** y pegarlo en la raiz del proyecto con el nombre **.env**.

4. Generar clave de cifrado.
```bash
php artisan key:generate
```

5. Ejecutar migraciones.
```bash
php artisan migrate
```

6. Ejecutar seeders.
```bash
php artisan db:seed
```

7. Iniciar servidor.
```bash
php artisan serve
```

## 🧾 License
The MIT License (MIT)