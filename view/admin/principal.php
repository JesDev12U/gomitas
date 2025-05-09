<div class="container-name">
  <h1 id="title-name">¡Bienvenido <?php echo $_SESSION["datos"]["usuario"] ?>!</h1>
  <p>¿Qué desea realizar hoy?</p>
</div>
<div class="container" id="menu">
  <div class="row">
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_CLIENTES ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_clientes.png" alt="Gestor de clientes">
        <p>Gestor de clientes</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_ADMINISTRADORES ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_administradores.png" alt="Gestor de administradores">
        <p>Gestor de administradores</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_PRODUCTOS ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_productos.jpg" alt="Gestor de productos">
        <p>Gestor de productos</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_GESTOR_VENTAS ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/gestor_ventas.png" alt="Gestor de ventas">
        <p>Gestor de ventas</p>
      </a>
    </div>
    <div class="col">
      <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_CUENTA ?>">
        <img src="<?php echo SITE_URL ?>img/menu_icons/cuenta.png" alt="Configuración de la cuenta">
        <p>Configuración de la cuenta</p>
      </a>
    </div>
  </div>
</div>