## Finkok manifest signer

REST API encargada de firmar el manifiesto del Pac Finkok.

## Comenzando 💪🚀

Estas instrucciones te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas.

### Pre-requisitos 📋

_Que cosas necesitas para poner en marcha el proyecto y como instalarlos_

* GIT [Link](https://git-scm.com/downloads)
* Entorno de servidor local, Ej: [Laragon](https://laragon.org/download/), [XAMPP](https://www.apachefriends.org/es/index.html) o [LAMPP](https://bitnami.com/stack/lamp/installer).
* PHP Version > 7.4 || 8.0 [Link](https://www.php.net/downloads.php).
* Manejador de dependencias de PHP [Composer](https://getcomposer.org/download/).

### Instalación 🔧

Paso a paso de lo que debes ejecutar para tener el proyecto ejecutandose


 1. Clona el repositorio dentro de la carpeta de tu servidor con el siguiente comando:
    ```
    git clone https://github.com/andreypootmay/finkok-manifest-signer.git
    ```
 2. Ingresa a la carpeta del repositorio
    ```
    cd repositorio
    ```
 3. Instala las dependencias del proyecto
    ```
    composer install
    ```
 4. Crea el archivo ".env" copiando la información del [ejemplo](https://github.com/andreypootmay/finkok-manifest-signer/blob/main/.env.example) y cambiar valores de su Base de datos (en caso de no contar con una base de datos ejecute el siguiente comando en mysql: `CREATE DATABASE finkok_manifesto_signer_app CHARACTER SET utf8 COLLATE utf8_general_ci;`).
 5. Ejecute las migraciones
    ```
    php artisan migrate --seed
    ```
 6. Instalar las dependencias de laravel passport:
    ```
    php artisan passport:install
    ```
 7. Inicialice el servidor local
    ```
    php artisan serve
    ```
 8. Listo, ya podrá visualizar e interactuar con el proyecto en local 😁.


## Request collection en insomnia

Puede revisar el request collection en insomnia importando el archivo ubicado en `docs/insomnia/`.

## Construido con 🛠️

Las herramientas que utilice para crear este proyecto:

* Framework de PHP [Laravel](https://laravel.com/docs/8.x).
* Laravel passport [Control de autenticación para REST APIS](https://laravel.com/docs/9.x/passport).
* Librería Finkok [Librería para consumir WS del PAC Finkok](https://github.com/phpcfdi/finkok).

## Autores ✒️

* **Niger Andrey Poot May** - *Development and documentation* - GitLab: [andreypootmay](https://gitlab.com/andreypootmay) GitHub: [andreypootmay](https://github.com/andreypootmay)
