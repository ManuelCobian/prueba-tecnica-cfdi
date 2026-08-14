# Prueba técnica ENEGENCE

Aplicación Laravel desarrollada para las pruebas técnicas de ENEGENCE.

## 1. Generación CFDI 4.0

Módulo para generar un XML CFDI 4.0 de tipo Ingreso a partir del JSON proporcionado.

### Funcionalidades

- Lectura del archivo JSON.
- Cálculo del importe de cada concepto.
- Cálculo de IVA por concepto.
- Cálculo de subtotal, impuestos y total.
- Generación del XML utilizando `DOMDocument`.
- Generación de Emisor, Receptor, Conceptos e Impuestos.
- Validación del XML contra el XSD de CFDI 4.0.
- Manejo de errores de validación.
- Generación y descarga del archivo XML.

> Para esta prueba no se realiza timbrado real ni se utilizan certificados `.cer`, `.key` o un PAC.

## Stack

- Laravel 12
- PHP 8.2+
- MySQL
- Livewire 3
- Rappasoft Livewire Tables
- DOMDocument
- XML / XSD

## Credenciales

Usuario:

```text
guestaccount@gmail.com
```

Contraseña:

```text
12345678
```

## Instalación

### 1. Clonar repositorio

```bash
git clone https://github.com/ManuelCobian/prueba-tecnica-cfdi
cd prueba-tecnica-cfdi
```

### 2. Instalar dependencias

```bash
composer install
npm install
npm run build
```

### 3. Configurar .env

```env
APP_NAME=ENEGENCE
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_LOCALE=es
```

Configurar la conexión a MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inegi
DB_USERNAME=root
DB_PASSWORD=
```

Generar la clave:

```bash
php artisan key:generate
```

Ejecutar migraciones y seeders:

```bash
php artisan migrate --seed
```

## Configuración CFDI

Agregar al `.env`:

```env
SAT_NAMESPACE=http://www.sat.gob.mx/cfd/4
SAT_XSI_NAMESPACE=http://www.w3.org/2001/XMLSchema-instance
SAT_XSD=https://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd
SAT_XSD_LOCAL=resources/xsd/cfdv40.xsd
```

El JSON utilizado para generar el CFDI se encuentra en:

```text
resources/cfdi/input.json
```

El XSD utilizado para la validación se encuentra en:

```text
resources/xsd/cfdv40.xsd
```

## Tests

```bash
php artisan test
```