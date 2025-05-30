# Fashe

**Fashe** es una tienda online de accesorios desarrollada en PHP (WAMP) con arquitectura MVC, token JWT propio, y funcionalidades modernas:

- 🏠 **Home** con carrusel de productos destacados
- 🔍 **Búsqueda** dinámica con AJAX, paginación y orden
- 🛍️ **Shop**: listado de accesorios con mini-carrusel de imágenes, likes por usuario, y paginación
- 📦 **Detalle** de producto con descripción y botón "Add to Cart"
- 🔐 **Autenticación**: registro, login, recuperación y reseteo de contraseña vía email (Resend API)
- 👥 **Social Login** con Google y GitHub (Firebase Auth)
- 🔒 **Protección de rutas**, control de sesión activa e identidad con JWT
- 📧 **Envío de emails** de validación y recuperación usando Resend API

## Tecnologías

- **Frontend**
  - HTML5, CSS3
  - jQuery (AJAX, validaciones)
  - [Slick Carousel](https://kenwheeler.github.io/slick/) para sliders
  - [SweetAlert2](https://sweetalert2.github.io/) para alertas
  - Firebase Auth (SDK compat JS) para Social Login
- **Backend**
  - PHP 8.x (WAMP)
  - MySQL
  - MVC:
    - **Controllers**: `module/*/controller/*.php`
    - **Models** (simple wrapper): `module/*/model/*_model.class.singleton.php`
    - **BLL** (lógica de negocio): `module/*/model/BLL/*.class.singleton.php`
    - **DAO** (acceso a BD): `module/*/model/DAO/*.class.singleton.php`
  - JWT propio (en `utils/jwt_process.inc.php`)
  - Emails con **Resend** (`utils/mail.inc.php`)

## Instalación y puesta en marcha

Antes de desplegar, configura las siguientes APIs:

- **Resend (emails)**
  - En `utils/mail.inc.php`, reemplaza:
    ```php
    private static $apiKey = 're_TU_API_KEY_DE_RESEND';
    ```
  - Ajusta también las direcciones `from` y las plantillas de correo.

- **Firebase (Social Login)**
  - Copia tu configuración web (API key, authDomain, projectId, etc.) en el fichero JS donde inicializas Firebase:
    ```js
    const firebaseConfig = {
      apiKey: "TU_API_KEY_DE_FIREBASE",
      authDomain: "fashe-96c90.firebaseapp.com",
      projectId: "fashe-96c90",
      storageBucket: "fashe-96c90.appspot.com",
      messagingSenderId: "433381109779",
      appId: "1:433381109779:web:...",
      measurementId: "G-..."
    };
    ```

- **(Opcional) Firebase Admin SDK**
  - Si validas tokens en backend, descarga la clave privada desde la consola de Firebase (Cuentas de servicio) y colócala en `utils/firebase-service-account.json`.
  - Asegúrate de instalar la librería:
    ```bash
    composer require kreait/firebase-php:^7.0 --with-all-dependencies
    ```

- **SSL para cURL**
  - Descarga `cacert.pem` desde https://curl.se/ca/cacert.pem y sitúalo en tu entorno PHP.
  - En `php.ini` (Apache), configura:
    ```ini
    curl.cainfo = "C:/ruta/a/extras/ssl/cacert.pem"
    openssl.cafile = "C:/ruta/a/extras/ssl/cacert.pem"
    ```
  - Reinicia Apache.

## Uso

- **Registro**: se envía un email de confirmación (Resend). Hasta validar, `activo=0` y no podrás iniciar sesión.
- **Login**: email+contraseña o Social (Google/GitHub). Al loguearte, se guarda el JWT en `localStorage`.
- **Recuperar contraseña**: solo cuenta `provider='email'`.
- **Likes**: haz click en el corazón; se guardan en la tabla `likes`.
- **Rutas protegidas**: `protectUrl()`, `controlActivity()`, `refreshToken()` en `activity_user.js` mantienen la sesión viva.

---

**¡Gracias por usar Fashe!**  
Comentarios y pull requests son bienvenidos.  
Licencia MIT.
