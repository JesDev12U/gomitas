<?php
set_include_path(
  get_include_path() .
    PATH_SEPARATOR . realpath(__DIR__ . '/..') . '/model' .
    PATH_SEPARATOR . realpath(__DIR__ . '/..') . '/controller' .
    PATH_SEPARATOR . realpath(__DIR__ . '/..') . '/classes'
);

define("SITE_URL", "http://localhost/");

// ** BASE DE DATOS **
define("DB_HOST", "127.0.0.1");
define("DB_BASE", "gomitas");
define("DB_USR", "root");
define("DB_PASS", "Str0ngPassword!");

// ** CONFIGURACIÓN GENERAL **
define("TIMEZONE", "America/Mexico_City");
define("METODO_ENCRIPTACION", "AES-256-CBC");
define("KEY_ENCRIPTACION", "u7<fijrf0AKI./");

// ** RUTAS GENERALES **
define("RUTA_ADMINISTRADOR", "administrador/");
define("RUTA_CLIENTE", "cliente/");
define("RUTA_CERRAR_SESION", "controller/cerrarSesion.php");
define("RUTA_CREAR_CUENTA", "crear-cuenta/");
define("RUTA_LOGIN", "login/");
define("RUTA_CUENTA", "cuenta/");

// ** RUTAS DEL ADMINISTRADOR **
define("RUTA_GESTOR_CLIENTES", "gestor-clientes/");
define("RUTA_GESTOR_ADMINISTRADORES", "gestor-administradores/");
define("RUTA_MTO_ADMINISTRADORES", "mto-administradores/");
define("RUTA_MTO_CLIENTES", "mto-clientes/");
define("RUTA_GESTOR_PRODUCTOS", "gestor-productos/");
define("RUTA_MTO_PRODUCTOS", "mto-productos/");
define("RUTA_GESTOR_VENTAS", "ventas/");

// ** RUTAS DEL CLIENTE **
define("RUTA_CARRITO", "carrito/");

// ** ÍCONOS FONT AWESOME **
define("ICON_CERRAR_SESION", '<i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión');
define("ICON_CUENTA", '<i class="fa-solid fa-gear"></i> Cuenta');
define("ICON_EMPLEADOS", '<i class="fa-solid fa-user-tie"></i> Empleados');
define("ICON_HOME", '<i class="fa-solid fa-house"></i> Home');
define("ICON_INICIAR_SESION", '<i class="fa-solid fa-user"></i> Acceder');
define("ICON_CARRITO", '<i class="fa-solid fa-cart-shopping"></i> Carrito');
define("ICON_PEDIDOS", '<i class="fa-solid fa-clipboard-list"></i> Pedidos');
define("ICON_HISTORIAL_COMPRAS", '<i class="fa-solid fa-bag-shopping"></i> Compras');
