# Bienes Raíces MVC

Aplicación web de bienes raíces desarrollada en PHP con arquitectura MVC, MySQL, Composer, Sass y Gulp. El proyecto permite mostrar propiedades en la interfaz pública, gestionar vendedores y propiedades desde un panel administrativo, así como recibir mensajes de contacto a través de un formulario.

## Características principales

- Catálogo público de propiedades con vista detallada.
- Panel de administración para crear, editar y eliminar propiedades.
- Gestión de vendedores.
- Sistema de autenticación para el área privada.
- Formulario de contacto con envío de correos mediante PHPMailer.
- Diseño responsivo con Sass y assets compilados con Gulp.

## Tecnologías utilizadas

- PHP 8+
- MySQL
- Composer
- MVC personalizado
- PHPMailer
- Intervention Image
- Dotenv
- Sass
- Gulp
- JavaScript

## Estructura del proyecto

```text
controllers/       Controladores de páginas, propiedades, vendedores y login
models/            Modelos y lógica de acceso a datos
views/             Vistas públicas y del panel admin
includes/          Configuración, funciones auxiliares y variables de entorno
public/            Punto de entrada de la aplicación y recursos públicos
src/               Archivos fuente de estilos y JavaScript
vendor/            Dependencias instaladas con Composer
```

## Requisitos previos

Antes de ejecutar la aplicación asegúrate de tener instalado:

- PHP 8 o superior
- Composer
- MySQL
- Node.js y npm
- Gulp CLI (opcional, si deseas compilar estilos y JS manualmente)

## Instalación

1. Clona el repositorio:

```bash
git clone <url-del-repositorio>
cd real_state_mvc
```

2. Instala las dependencias de PHP:

```bash
composer install
```

3. Instala las dependencias de frontend:

```bash
npm install
```

4. Compila los assets:

```bash
npm run dev
```

## Configuración de la base de datos

Crea un archivo de entorno en la carpeta [includes](includes) llamado `.env` con las siguientes variables:

```env
DB_HOST=localhost
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
DB_NAME=tu_base_de_datos
```

El proyecto ya está preparado para leer estas variables desde [includes/config/database.php](includes/config/database.php).

### Esquema básico recomendado

Puedes crear las tablas con una estructura similar a esta:

```sql
CREATE TABLE sellers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL
);

CREATE TABLE properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    bedrooms INT NOT NULL,
    wc INT NOT NULL,
    parking_space INT NOT NULL,
    created VARCHAR(20) NOT NULL,
    sellers_id INT NOT NULL,
    FOREIGN KEY (sellers_id) REFERENCES sellers(id)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
```

Para acceder al panel administrativo, crea un usuario en la tabla `users` con una contraseña hasheada mediante `password_hash()`.

## Ejecución local

Inicia el servidor de PHP apuntando al directorio público:

```bash
php -S localhost:8000 -t public
```

Luego abre en tu navegador:

```text
http://localhost:8000
```

## Rutas principales

- `/` → Inicio
- `/properties` → Listado de propiedades
- `/listing` → Detalle de una propiedad
- `/contact` → Formulario de contacto
- `/login` → Inicio de sesión del administrador
- `/admin` → Panel administrativo

## Panel de administración

Una vez autenticado, podrás:

- Administrar propiedades
- Crear y editar vendedores
- Subir imágenes de propiedades
- Ver mensajes y gestionar el contenido del sitio

## Notas importantes

- Las imágenes subidas se almacenan en el directorio público de imágenes configurado por el proyecto.
- El formulario de contacto está preparado para trabajar con SMTP. Si deseas usar otro proveedor, ajusta las credenciales en [controllers/PageController.php](controllers/PageController.php).
- El proyecto está pensado como una práctica educativa y puede ampliarse con autenticación más robusta, validaciones adicionales o una API.

## Autor

Proyecto desarrollado por Erik Kings.
