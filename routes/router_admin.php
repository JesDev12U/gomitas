<?php
switch ($action) {
  case NULL:
    require_once __DIR__ . "/../controller/admin/CtrlPaginaPrincipal.php";
    $ctrl = new CtrlPaginaPrincipal();
    break;
  case rtrim(RUTA_GESTOR_CLIENTES, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_clientes/CtrlGestorClientes.php";
    $ctrl = new CtrlGestorClientes();
    break;
  case rtrim(RUTA_MTO_CLIENTES, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_clientes/CtrlMtoClientes.php";
    if (is_null($id)) {
      $ctrl = new CtrlMtoClientes("INSERT");
    } else if ($id > 0) {
      $ctrl = new CtrlMtoClientes("UPDATE", $id);
      $registro = $ctrl->seleccionaRegistro($id);
      if (count($registro) == 0) {
        // Página no encontrada
        require_once __DIR__ . "/../controller/errors/CtrlError404.php";
        http_response_code(404);
        $ctrl = new CtrlError404();
      }
    } else {
      // Página no encontrada
      require_once __DIR__ . "/../controller/errors/CtrlError404.php";
      http_response_code(404);
      $ctrl = new CtrlError404();
    }
    break;
  case rtrim(RUTA_GESTOR_ADMINISTRADORES, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_administradores/CtrlGestorAdministradores.php";
    $ctrl = new CtrlGestorAdministradores();
    break;
  case rtrim(RUTA_MTO_ADMINISTRADORES, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_administradores/CtrlMtoAdministradores.php";
    if (is_null($id)) {
      $ctrl = new CtrlMtoAdministradores("INSERT", null, true);
    } else if ($id > 0 && $id != $_SESSION["datos"]["id_admin"]) {
      $ctrl = new CtrlMtoAdministradores("UPDATE", $id, true);
      $registro = $ctrl->seleccionaRegistro($id);
      if (count($registro) == 0) {
        // Página no encontrada
        require_once __DIR__ . "/../controller/errors/CtrlError404.php";
        http_response_code(404);
        $ctrl = new CtrlError404();
      }
    } else {
      // Página no encontrada
      require_once __DIR__ . "/../controller/errors/CtrlError404.php";
      http_response_code(404);
      $ctrl = new CtrlError404();
    }
    break;
  case rtrim(RUTA_CUENTA, "/"):
    require_once __DIR__ . "/../controller/admin/gestor_administradores/CtrlMtoAdministradores.php";
    $ctrl = new CtrlMtoAdministradores("UPDATE", $_SESSION["datos"]["id_admin"], false);
    break;
  case rtrim(RUTA_GESTOR_PRODUCTOS, "/"):
    require_once __DIR__ . "/../controller/admin/gestor_productos/CtrlGestorProductos.php";
    $ctrl = new CtrlGestorProductos();
    break;
  case rtrim(RUTA_MTO_PRODUCTOS, '/'):
    require_once __DIR__ . "/../controller/admin/gestor_productos/CtrlMtoProductos.php";
    if (is_null($id)) {
      $ctrl = new CtrlMtoProductos("INSERT");
    } else if ($id > 0) {
      $ctrl = new CtrlMtoProductos("UPDATE", $id);
      $registro = $ctrl->seleccionaRegistro($id);
      if (count($registro) == 0) {
        // Página no encontrada
        require_once __DIR__ . "/../controller/errors/CtrlError404.php";
        http_response_code(404);
        $ctrl = new CtrlError404();
      }
    } else {
      // Página no encontrada
      require_once __DIR__ . "/../controller/errors/CtrlError404.php";
      http_response_code(404);
      $ctrl = new CtrlError404();
    }
    break;
  case rtrim(RUTA_GESTOR_VENTAS, "/"):
    require_once __DIR__ . "/../controller/admin/gestor_ventas/CtrlGestorVentas.php";
    $ctrl = new CtrlGestorVentas();
    break;
  default:
    // Página no encontrada
    require_once __DIR__ . "/../controller/errors/CtrlError404.php";
    http_response_code(404);
    $ctrl = new CtrlError404();
}
