# Prueba técnica CFDI 4.0

Generación programática y validación de un CFDI 4.0
de tipo Ingreso utilizando PHP.

## Requisitos

PHP 8.2+
Composer
ext-dom
ext-libxml

## Instalación

composer install

cp .env.example .env

php artisan key:generate


## Tests

php artisan test

## Arquitectura

CfdiCalculator
Realiza los cálculos de importes, IVA, subtotal y total.

CfdiXmlGenerator
Construye el CFDI utilizando DOMDocument.

CfdiValidator
Valida el XML contra el esquema XSD oficial del SAT.

## Resultado esperado

Subtotal: $8,026.46
IVA: $1,284.23
Total: $9,310.69

## Consideraciones

La solución no realiza timbrado ni utiliza un PAC.
No se utilizan certificados .cer/.key ni se genera un sello real.