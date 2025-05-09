<?php
ini_set('display_errors', E_ALL);
require_once __DIR__ . "/../../config/Global.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["result" => 0, "msg" => "Método no permitido"]);
  die();
}

// Recepción de los datos
$id = isset($_POST['id']) ? (int)$_POST['id'] : null;
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$operacion = isset($_POST["operacion"]) ? $_POST['operacion'] : null;

if (!$id || !$usuario || !$operacion) {
  echo json_encode(["result" => 0, "msg" => "Petición incorrecta"]);
  die();
}

// Verificar si el ID existe
if ($usuario === "administrador") {
  require_once __DIR__ . "/gestor_administradores/CtrlMtoAdministradores.php";
  $ctrl = new CtrlMtoAdministradores("UPDATE", null, true);
} else if ($usuario === "cliente") {
  require_once __DIR__ . "/gestor_clientes/CtrlMtoClientes.php";
  $ctrl = new CtrlMtoClientes("UPDATE");
} else if ($usuario === "producto") {
  // require_once __DIR__ . "/../empleado/gestor_productos/CtrlMtoProductos.php";
  // $ctrl = new CtrlMtoProductos("UPDATE");
} else {
  echo json_encode(["result" => 0, "msg" => "Usuario inválido"]);
  die();
}

if (count($ctrl->seleccionaRegistro($id)) === 0) {
  echo json_encode(["result" => 0, "msg" => "El ID del usuario no existe"]);
  die();
}

// Ya con todo correcto, se hace la solicitud
//if ($usuario === "administrador") $ctrl = new CtrlMtoAdministradores("UPDATE", $id, true);
switch ($operacion) {
  case "deshabilitar":
    if ($ctrl->deshabilitarRegistro($id)) {
      echo json_encode(["result" => 1, "msg" => ucfirst($usuario) . " deshabilitado correctamente"]);
    } else {
      echo json_encode(["result" => 0, "msg" => "ERROR: Problema para actualizar el registro en la Base de Datos"]);
    }
    break;
  case "habilitar":
    if ($ctrl->habilitarRegistro($id)) {
      echo json_encode(["result" => 1, "msg" => ucfirst($usuario) . " habilitado correctamente"]);
    } else {
      echo json_encode(["result" => 0, "msg" => "ERROR: Problema para actualizar el registro en la Base de Datos"]);
    }
    break;
  default:
    echo json_encode(["result" => 0, "msg" => "Operación inválida"]);
    die();
}
