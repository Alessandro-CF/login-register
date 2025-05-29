# Sistema de Login y Registro con PHP y Tailwind CSS

Un sistema completo de autenticación con arquitectura MVC, validaciones del lado cliente y servidor, y una interfaz moderna con Tailwind CSS.

## Características

- Arquitectura MVC limpia y organizada
- Validaciones en tiempo real con JavaScript
- Validaciones del lado servidor con PHP
- Interfaz moderna y responsiva con Tailwind CSS
- Indicador de fortaleza de contraseña
- Animaciones y transiciones suaves
- Mensajes de error y éxito dinámicos
- Seguridad con hash de contraseñas
- Manejo de sesiones

## Estructura del Proyecto

```
Login-Register/
├── config/
│   └── database.php         # Configuración de base de datos
├── controllers/
│   └── AuthController.php   # Controlador de autenticación
├── models/
│   └── User.php            # Modelo de usuario
├── views/
│   ├── register.php        # Vista de registro
│   └── login.php           # Vista de login
├── public/
│   ├── css/
│   │   └── styles.css      # Estilos personalizados
│   ├── js/
│   │   ├── register.js     # JavaScript para registro
│   │   └── login.js        # JavaScript para login
│   └── images/             # Imágenes del proyecto
├── routes/
│   └── web.php             # Definición de rutas
└── index.php               # Archivo principal
```

## Instalación

### Prerrequisitos

- XAMPP, WAMP, Laragon o cualquier servidor local con PHP y MySQL
- PHP 7.4 o superior
- MySQL 5.7 o superior

### Pasos de Instalación

1. **Clonar o descargar el proyecto**
   ```bash
   # Si usas Git
   git clone [URL_DEL_REPOSITORIO]
   
   # O simplemente descarga y extrae los archivos
   ```

2. **Configurar el servidor local**
   - Coloca la carpeta del proyecto en tu directorio web (htdocs, www, etc.)
   - Asegúrate de que Apache y MySQL estén corriendo

3. **Crear la base de datos**
   ```sql
   CREATE DATABASE login_register_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Configurar la conexión a la base de datos**
   - Edita `config/database.php` si es necesario
   - Por defecto usa:
     - Host: localhost
     - Database: login_register_db
     - Usuario: root
     - Contraseña: (vacía)
5. **Validar entorno de despliegue**
   - Abre tu navegador web
   - Ve a: `http://localhost/Login-Register/check.php`

6. **Acceder a la aplicación**
   - Abre tu navegador web
   - Ve a: `http://localhost/Login-Register` (o la ruta donde hayas colocado el proyecto)

### Configuración Automática

La aplicación creará automáticamente la tabla `users` la primera vez que se ejecute. No necesitas ejecutar scripts SQL adicionales.

## Uso

### Registro de Usuario

1. Ve a la página principal (registro)
2. Completa todos los campos:
   - **Nombre**: Nombre completo del usuario
   - **Correo**: Email válido (debe ser único)
   - **Contraseña**: Mínimo 6 caracteres
   - **Repetir Contraseña**: Debe coincidir con la contraseña
   - **Tipo de Usuario**: Selecciona entre Usuario o Administrador

3. El sistema validará en tiempo real:
   - Formato del email
   - Fortaleza de la contraseña
   - Coincidencia de contraseñas
   - Campos obligatorios

### Inicio de Sesión

1. Ve a la página de login
2. Ingresa tu correo y contraseña
3. El sistema verificará las credenciales

## Características de la Interfaz

### Validaciones en Tiempo Real

- **Nombre**: Solo letras y espacios, mínimo 2 caracteres
- **Email**: Formato válido de correo electrónico
- **Contraseña**: Indicador visual de fortaleza
- **Confirmación**: Verificación automática de coincidencia

### Animaciones y Efectos

- Transiciones suaves en hover y focus
- Animaciones de entrada (fade-in, slide-up)
- Efecto shake en campos con errores
- Loading spinner en envío de formularios
- Auto-ocultado de mensajes

### Responsividad

- Diseño completamente responsivo
- Optimizado para dispositivos móviles
- Navegación táctil amigable

## Personalización

### Colores y Estilos

Puedes personalizar los colores editando las clases de Tailwind CSS en las vistas:

```html
<!-- Cambiar color primario -->
<button class="bg-indigo-600 hover:bg-indigo-700">
  <!-- Cambiar por cualquier color de Tailwind -->
  <button class="bg-purple-600 hover:bg-purple-700">
```

### Validaciones

Para añadir nuevas validaciones, edita:

- **Frontend**: `public/js/register.js` o `public/js/login.js`
- **Backend**: `models/User.php` método `validate()`

### Base de Datos

Para cambiar la configuración de base de datos, edita `config/database.php`:

```php
private $host = 'tu-host';
private $db_name = 'tu-database';
private $username = 'tu-usuario';
private $password = 'tu-contraseña';
```

## Seguridad

- Contraseñas hasheadas con `password_hash()`
- Validación y sanitización de datos de entrada
- Protección contra inyección SQL con PDO
- Manejo seguro de sesiones
- Validación tanto en cliente como servidor

## Próximas Mejoras

- [ ] Recuperación de contraseña por email
- [ ] Verificación de email
- [ ] Dashboard para usuarios logueados
- [ ] Roles y permisos avanzados
- [ ] Remember me functionality
- [ ] Two-factor authentication

## Notas Técnicas

- **PHP**: Versión 7.4+
- **Base de Datos**: MySQL con PDO
- **Frontend**: Tailwind CSS 3.x
- **JavaScript**: Vanilla JS (ES6+)
- **Patrón**: MVC (Model-View-Controller)

## Contribuciones

¡Las contribuciones son bienvenidas! Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature
3. Commit tus cambios
4. Push a la rama
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Soporte

Si encuentras algún problema o tienes preguntas:

1. Revisa que tu servidor local esté configurado correctamente
2. Verifica que la base de datos esté creada
3. Revisa los logs de PHP para errores
4. Asegúrate de que las rutas sean correctas

¡Happy coding!
