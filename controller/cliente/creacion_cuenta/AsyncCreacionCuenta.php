<?php
ini_set('display_errors',  E_ALL);
session_start();

require_once __DIR__ . "/../../../config/Global.php";
require_once __DIR__ . "/../../../classes/Email.php";
require_once __DIR__ . "/../../admin/gestor_clientes/CtrlMtoClientes.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["result" => 0, "msg" => "Método no permitido"]);
  die();
}

// Recepción de los datos
$operacion = isset($_POST["operacion"]) ? $_POST["operacion"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$codigo = isset($_POST["codigo"]) ? $_POST["codigo"] : "";
$usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

if (
  !$operacion
  && !$usuario
  && !$email
  && !$codigo
  && !$password
) {
  header('Content-Type: application/json');
  $jsonData = file_get_contents("php://input");
  $data = json_encode($jsonData, true);
  $operacion = $data['operacion'] ?? null;
  $usuario = $data['usuario'] ?? null;
  $email = $data['email'] ?? null;
  $codigo = $data['codigo'] ?? null;
  $password = $data['password'] ?? null;
}

// Procesamiento de los datos
switch ($operacion) {
  case "enviar_codigo":
    $Email = new Email($email);
    if ($Email->existeEmail()) {
      echo json_encode(["result" => 0, "msg" => "El email ingresado ya existe en nuestra base de datos, por favor ingresa otro"]);
      die();
    }
    $codigoVerificacion = $Email->enviarCodigo();
    if ($codigoVerificacion === null) {
      echo json_encode(["result" => 0, "msg" => "Error al enviar el código"]);
    } else {
      echo json_encode(["result" => 1]);
      $_SESSION["codigo"] = $codigoVerificacion;
    }
    break;
  case "comprobar_codigo":
    if (!isset($_SESSION['codigo'])) {
      echo json_encode(["result" => 0, "msg" => "No haz solicitado el código"]);
    } else if ($codigo != $_SESSION["codigo"]) {
      echo json_encode(["result" => 0, "msg" => "Código inválido"]);
    } else if ($codigo == $_SESSION["codigo"]) {
      // Crear cuenta
      $ctrl = new CtrlMtoClientes("INSERT");
      if (!$ctrl->validaAtributos(
        null,
        $usuario,
        $email,
        $password,
      )) {
        echo json_encode(["result" => 0, "msg" => "ERROR: Datos inválidos"]);
      } else {
        if ($ctrl->insertaRegistro(
          $usuario,
          $email,
          password_hash($password, PASSWORD_DEFAULT),
        )) {
          session_unset();
          session_destroy();
          echo json_encode(["result" => 1, "msg" => "¡Cuenta creada correctamente!"]);
        } else {
          echo json_encode(["result" => 0, "msg" => "ERROR: Problema de inserción en BD"]);
        }
      }
    }
    break;
}
