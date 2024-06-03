# ComicHub

## Acerca del Proyecto Marvel Laravel

Este proyecto es una aplicación web construida con Laravel que utiliza la API de Marvel. Cuenta con un buscador, un explorador, una lista de lectura, gestión de usuarios, una página de contacto, una página de "Quiénes somos", y más.

## Características

- Buscador de cómics de Marvel.
- Explorador de cómics de Marvel.
- Lista de lectura personalizada.
- Gestión de usuarios.
- Página de contacto.
- Página de "Quiénes somos".

## Instalación

Sigue estos pasos para instalar y ejecutar el proyecto Marvel Laravel en tu máquina local para propósitos de desarrollo y pruebas.

### Prerrequisitos

Necesitarás tener instalado PHP, Composer y un servidor de base de datos MySQL en tu máquina local. También necesitarás una clave de API de Marvel.

### Pasos

1. Clona el repositorio en tu máquina local:

git clone https://github.com/ruimar-dev/ComicHub-app.git

2. Navega al directorio del proyecto:

cd ComicHub-app

3. Instala las dependencias del proyecto con Composer:

composer install

4. Copia el archivo .env.example a un nuevo archivo llamado .env:

cp .env.example .env

5. Genera una nueva clave de aplicación:

php artisan key:generate

6. Abre el archivo .env y configura tus credenciales de base de datos y tu clave de API de Marvel.

7. Ejecuta las migraciones de la base de datos:

php artisan migrate

8. Inicia el servidor de desarrollo local:

php artisan serve

Ahora deberías poder acceder a la aplicación en http://localhost:8000.

## Aprendiendo Laravel

Laravel tiene la documentación más extensa y completa y la biblioteca de tutoriales en video de todos los marcos de aplicaciones web modernas, lo que facilita comenzar con el marco.

## Contribuyendo

Gracias por considerar contribuir al proyecto ComicHub! La guía de contribución se puede encontrar en la [documentación de Laravel](https://laravel.com/docs/contributions).

## Código de Conducta

Para asegurar que la comunidad de Laravel sea acogedora para todos, por favor revisa y cumple con el [Código de Conducta](https://laravel.com/docs/contributions#code-of-conduct).

## Vulnerabilidades de Seguridad

Si descubres una vulnerabilidad de seguridad dentro de Laravel, por favor envía un correo electrónico a Taylor Otwell a través de [taylor@laravel.com](mailto:taylor@laravel.com). Todas las vulnerabilidades de seguridad serán atendidas de inmediato.

## Licencia

El proyecto Marvel Laravel es un software de código abierto con licencia bajo la [licencia MIT](https://opensource.org/licenses/MIT).
