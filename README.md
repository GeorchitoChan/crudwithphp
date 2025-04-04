# CRUD Completo en PHP Puro con Bootstrap y MySQL

## Descripción

Este proyecto es un CRUD (Crear, Leer, Actualizar, Eliminar) completo desarrollado en **PHP puro** utilizando **Bootstrap** para la interfaz de usuario y **MySQL** como sistema gestor de base de datos. La aplicación permite gestionar usuarios mediante una interfaz simple y segura.

El proyecto implementa el patrón **MVC** (Modelo-Vista-Controlador) para mantener una estructura organizada y escalable. Además, se han aplicado medidas de seguridad esenciales para proteger la aplicación, como la protección contra **inyección SQL**, la utilización de **PDO** para consultas seguras, y la implementación de un **token CSRF** para proteger los formularios.

## Características

- **Interfaz de Usuario**: Utiliza **Bootstrap** (última versión) para el diseño y la experiencia de usuario.
- **Gestión de Usuarios**: Puedes agregar, editar, listar y eliminar usuarios.
- **Seguridad**:
  - **Prevención de Inyección SQL**: Utiliza **PDO** para realizar consultas seguras.
  - **Protección CSRF**: Cada formulario incluye un token **CSRF** para proteger contra ataques de falsificación de solicitud entre sitios.
  - **Hashing de Contraseñas**: Las contraseñas de los usuarios se almacenan de forma segura utilizando `password_hash()` y se verifican con `password_verify()`.

## Estructura del Proyecto

El proyecto sigue el patrón **MVC** (Modelo-Vista-Controlador), donde:

- **Modelos**: Se encargan de interactuar con la base de datos.
- **Vistas**: Son las páginas HTML que se muestran al usuario.
- **Controladores**: Gestionan la lógica de negocio y las peticiones del usuario.

## Base de Datos

El proyecto utiliza **MySQL** como sistema gestor de bases de datos. La base de datos contiene una tabla llamada **`users`** con la siguiente estructura:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
```
## Campos
- **id**: Identificador único para cada usuario (autoincremental).
- **name**: Nombre del usuario.
- **email**: Correo electrónico del usuario, único en la base de datos.
- **password**: Contraseña del usuario, almacenada de forma segura con un hash.

## Instalación
Para instalar y ejecutar este proyecto, sigue estos pasos:

1. Clona o descarga este repositorio.
2. Crea una base de datos en tu servidor MySQL.
3. Ejecuta el script SQL para crear la tabla users en tu base de datos.
3. Configura tu archivo de conexión a la base de datos ubicada en la carpeta core (conexion.php) con las credenciales de tu base de datos.
```php
// Configurar así si tienes cambiado el puerto del servidor web pero con tus datos reales de la conexión de tu entorno.

$this->db = new PDO("mysql:host=localhost;port=3307;dbname=mvc_db", "root", "");

// Caso contrario configurala así si no tienes cambiado el puerto del servidor web.

$this->db = new PDO("mysql:host=localhost;port=3307;dbname=mvc_db", "root", "");
```
4. Sube los archivos del proyecto a tu servidor local o de producción (por ejemplo, en un servidor Apache con PHP y MySQL). NOTA: En tu servidor web crea una carpeta llamada sherzer y ahí agrega los archivos del proyecto.

5. Accede a la aplicación desde tu navegador.
```
    http://localhost:8080/sherzer/public/users
```


## Seguridad Implementada
Este proyecto aplica varias medidas de seguridad para proteger la información de los usuarios:

### 1. Prevención de Inyección SQL
Para evitar inyecciones SQL, se utiliza PDO (PHP Data Objects) para realizar las consultas a la base de datos. PDO es una extensión de PHP que proporciona una interfaz segura y flexible para interactuar con bases de datos.

Ejemplo de una consulta segura con PDO:
```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch();
```
### 2. Protección CSRF
Se utiliza un token CSRF (Cross-Site Request Forgery) en cada formulario para proteger la aplicación contra ataques de falsificación de solicitudes entre sitios. Cada vez que se envía un formulario, se valida el token CSRF para asegurarse de que la solicitud proviene de una fuente confiable.

Ejemplo de inclusión de un token CSRF en un formulario:

```php
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">
```
### 3. Hashing de Contraseñas
Las contraseñas nunca se almacenan en texto claro en la base de datos. En su lugar, se almacenan como hashes utilizando el algoritmo bcrypt con la función `password_hash()`. Al verificar la contraseña, se utiliza `password_verify()` para comparar el hash con la contraseña ingresada.

Ejemplo de hashing de una contraseña:
```php
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
```
### 4. MVC (Modelo-Vista-Controlador)
El proyecto sigue el patrón MVC para organizar el código de manera clara y modular. El modelo se encarga de las interacciones con la base de datos, la vista se encarga de la presentación y el controlador maneja la lógica de negocio.

Esto mejora la mantenibilidad y escalabilidad del proyecto, permitiendo que se pueda ampliar o modificar sin afectar otras partes de la aplicación.

#### Uso
Una vez que el sistema esté configurado, podrás:

- **Crear un nuevo usuario**: Desde el formulario de creación de usuario.
- **Ver los usuarios existentes**: Una lista de usuarios registrados en el sistema.
- **Editar un usuario**: Cambiar el nombre, correo y contraseña de un usuario existente.
- **Eliminar un usuario**: Eliminar un usuario de la base de datos.

## Conclusión
Este proyecto es una demostración de cómo crear un sistema CRUD completo en PHP puro utilizando Bootstrap para el diseño de la interfaz y MySQL para la gestión de datos. Además, se han aplicado las mejores prácticas de seguridad para proteger los datos sensibles y evitar vulnerabilidades comunes en aplicaciones web.