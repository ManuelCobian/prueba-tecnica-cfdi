## Prueba técnica ENEGENCE

Aplicación Laravel que consume los servicios del Catálogo Único
de Claves Geoestadísticas del INEGI.

### Funcionalidades

- Consulta de las 32 entidades federativas.
- Persistencia en MySQL.
- Importación idempotente mediante updateOrCreate.
- Restricción UNIQUE sobre cve_ent.
- Listado paginado.
- Búsqueda de estados.
- Ordenamiento.
- Formateo de población.
- Consulta dinámica de municipios desde INEGI.
- Paginación de municipios.
- Manejo de errores del servicio externo.

### Stack

- Laravel 12
- PHP 8.2+
- MySQL
- Livewire 3
- Rappasoft Livewire Tables

## Demo

https://develop.clintec.net

## Credenciales SUPER USERS

Usuario:
guestaccount@gmail.com

Contraseña:
12345678

## ⚙️ Instalación

### 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/ManuelCobian/prueba-tecnica
cd tu-repositorio


2️⃣ Instalar dependencias
composer install
npm install
npm run build

3️⃣ Archivo .env

APP_NAME=ENEGENCE
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_LOCALE=es

4️⃣ Generar la clave de la aplicación
php artisan key:generate

 Configura tu conexión a MySQL en el archivo .env:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inegi
DB_USERNAME=root
DB_PASSWORD=

Ejecuta las migraciones junto con los seeders:

php artisan migrate --seed

