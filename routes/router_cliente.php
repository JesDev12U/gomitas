<?php
switch ($action) {
  case rtrim(RUTA_CUENTA, "/"):
    require_once __DIR__ . "/../controller/admin/gestor_clientes/CtrlMtoClientes.php";
    $ctrl = new CtrlMtoClientes("UPDATE", $_SESSION["datos"]["id_cliente"], "cliente");
    break;
}
