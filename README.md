# BiblioExpress - Taller CRUD con PHP y PDO

Proyecto académico de gestión de libros (**CRUD**: Crear, Leer, Actualizar y Eliminar) desarrollado con **PHP estructurado puro**, conexión a base de datos mediante **PDO** (compatible con MySQL y PostgreSQL) y estilos con **Bootstrap 5**.

---

## Estructura del Proyecto

- `database.sql` — Script SQL para crear la base de datos `biblio_express`, la tabla `libro` y 2 registros iniciales.
- `conexion.php` — Configuración modular de la conexión PDO con manejo de excepciones (`try-catch`).
- `index.php` — Página principal que lista todos los libros registrados y muestra alertas de confirmación.
- `crear.php` — Formulario HTML para registrar un nuevo libro.
- `guardar.php` — Recibe los datos por `POST`, valida campos y ejecuta el `INSERT` con sentencia preparada.
- `editar.php` — Consulta el libro por `GET`, precarga el formulario y ejecuta el `UPDATE` preparado.
- `eliminar.php` — Valida el `id_libro` recibido por `GET` y ejecuta el `DELETE` preparado.

---

## Requisitos Previos (Ubuntu en WSL)

Asegúrate de tener instalados PHP, la extensión `php-mysql` para PDO y MySQL Server. Si no los tienes, abre tu terminal de Ubuntu y ejecuta:

```bash
sudo apt update
sudo apt install -y php php-cli php-mysql mysql-server
```

Puedes comprobar que el driver PDO para MySQL esté activo con:

```bash
php -m | grep pdo_mysql
```

---

## Paso a Paso para Ejecutar el Proyecto

### 1. Iniciar el servicio de MySQL
En WSL los servicios no siempre inician solos al abrir la terminal. Inícialo con:

```bash
sudo service mysql start
```

### 2. Crear el usuario en MySQL y cargar la base de datos
En Ubuntu, el usuario `root` de MySQL usa `auth_socket` por defecto. Para que PHP pueda conectarse sin problemas, creamos el usuario `estudiante` con contraseña `sena1234` y le damos permisos sobre la base de datos `biblio_express`:

```bash
sudo mysql -u root << 'EOF'
CREATE DATABASE IF NOT EXISTS biblio_express CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'estudiante'@'localhost' IDENTIFIED BY 'sena1234';
GRANT ALL PRIVILEGES ON biblio_express.* TO 'estudiante'@'localhost';
FLUSH PRIVILEGES;
EOF
```

Ahora importamos la tabla `libro` y los 2 libros de prueba desde el archivo `database.sql`:

```bash
sudo mysql -u root biblio_express < ~/sena-projects/taller-crud/database.sql
```

> **Nota:** Si deseas usar otro usuario o contraseña de MySQL, solo debes cambiar las variables `$usuario` y `$password` al inicio del archivo `conexion.php`.

---

### 3. Levantar el servidor y abrir en el navegador

Tienes dos opciones para correr la aplicación:

#### Opción A: Usando el servidor interno de PHP (Más rápido y recomendado)
Ubícate en la carpeta del proyecto e inicia el servidor en el puerto `8000`:

```bash
cd ~/sena-projects/taller-crud
php -S localhost:8000
```

Luego abre tu navegador en:
**http://localhost:8000**

*(Para detener el servidor en la terminal, presiona `Ctrl + C`).*

---

#### Opción B: Usando Apache (`/var/www/html`)
Si prefieres ejecutarlo a través de Apache2:

```bash
sudo apt install -y apache2 libapache2-mod-php
sudo service apache2 start

sudo mkdir -p /var/www/html/biblio-express
sudo cp -r ~/sena-projects/taller-crud/* /var/www/html/biblio-express/
sudo chown -R $USER:www-data /var/www/html/biblio-express
sudo chmod -R 775 /var/www/html/biblio-express
```

Luego abre tu navegador en:
**http://localhost/biblio-express**

---

## Buenas Prácticas Implementadas

- **Prevención de Inyección SQL:** Uso de sentencias preparadas (`$pdo->prepare()` y `$stmt->execute()`) con parámetros nombrados (`:titulo`, `:isbn`, etc.).
- **Prevención básica de XSS:** Uso de `htmlspecialchars()` al imprimir datos en el HTML.
- **Validación en Servidor y Cliente:** Atributos `required` y `min` en los formularios HTML5, además de validaciones en PHP (`ano_publicacion > 1500`, `numero_paginas > 0` y campos obligatorios).


### Correrlo 100% en Windows con XAMPP (por ejemplo, en el PC del profesor o de un compañero)

#### El proyecto corre exactamente igual en XAMPP porque PDO (pdo_mysql) ya viene activado por defecto en XAMPP. Solo tendrías que hacer estos 4 pasos:

- **Copiar la carpeta del proyecto a htdocs:** Pegas la carpeta taller-crud dentro de C:\xampp\htdocs\ (quedaría C:\xampp\htdocs\taller-crud).
- **Encender Apache y MySQL:** Abres el panel de control de XAMPP y le das Start a Apache y MySQL.
- **Importar la base de datos en phpMyAdmin:** Entras a http://localhost/phpmyadmin, vas a la pestaña SQL, pegas el contenido de database.sql y le das a Continuar.
- **Ajustar el usuario en conexion.php:** En XAMPP sobre Windows, el usuario root no tiene contraseña y no tiene el bloqueo auth_socket de Ubuntu. Así que en conexion.php solo cambias esas dos líneas: