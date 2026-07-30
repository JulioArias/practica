# Inventario Boutique

![Laravel CI](https://github.com/JulioArias/practica/actions/workflows/laravel.yml/badge.svg)

Sistema de gestión de inventario para una boutique, desarrollado en **Laravel 11** con vistas en **Bootstrap 5**.

## Funcionalidades incluidas

- Autenticación simple (registro e inicio de sesión).
- CRUD completo de **Categorías**.
- CRUD completo de **Productos** (nombre, SKU, precio, stock, categoría), con búsqueda.
- Dashboard con totales de productos, categorías, stock y alerta de productos con stock bajo.

-hola esta es una prueba de funcionamiento

## Requisitos

- PHP >= 8.2
- Composer
- MySQL (o SQLite si prefieres algo más simple)
- Node.js (opcional, solo si vas a compilar assets con Vite)

## Instalación

1. Instala las dependencias de PHP:

   ```bash
   composer install
   ```

2. Copia el archivo de entorno y genera la clave de la aplicación:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. Configura tu base de datos en el archivo `.env` (por defecto usa MySQL):

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventario_boutique
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Si prefieres SQLite (más rápido para probar), crea el archivo y cambia la conexión:

   ```bash
   touch database/database.sqlite
   ```
   ```env
   DB_CONNECTION=sqlite
   ```

4. Ejecuta las migraciones y los seeders (esto crea un usuario de prueba y categorías/productos de ejemplo):

   ```bash
   php artisan migrate --seed
   ```

5. Levanta el servidor de desarrollo:

   ```bash
   php artisan serve
   ```

6. Abre `http://localhost:8000` en tu navegador.

## Usuario de prueba

Tras ejecutar el seeder, puedes iniciar sesión con:

- **Correo:** admin@boutique.com
- **Contraseña:** password

## Estructura relevante

```
app/
  Http/Controllers/         -> Controladores (Auth, Dashboard, Categorías, Productos)
  Models/                   -> User, Categoria, Producto
database/
  migrations/               -> Tablas: users, categorias, productos
  seeders/                  -> Datos de ejemplo
resources/views/
  layouts/app.blade.php     -> Layout con Bootstrap y tema boutique
  auth/                     -> Login y registro
  categorias/               -> Vistas CRUD de categorías
  productos/                -> Vistas CRUD de productos
routes/web.php              -> Todas las rutas de la aplicación
```

## Próximos pasos sugeridos

- Agregar roles de usuario (admin/vendedor).
- Módulo de proveedores y compras.
- Registro de ventas y reportes.
- Imágenes de productos (usando `php artisan storage:link`).
