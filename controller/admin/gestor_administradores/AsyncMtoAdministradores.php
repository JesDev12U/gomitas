<?php
ini_set('display_errors', E_ALL);
session_start();

require_once __DIR__ . "/../../../config/Global.php";
require_once __DIR__ . "/CtrlMtoAdministradores.php";
require_once __DIR__ . '/../../../classes/Email.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["result" => 0, "msg" => "Método no permitido"]);
  die();
}

// Recepción de los datos
$peticion = isset($_POST['peticion']) ? $_POST['peticion'] : "";
$id_admin = isset($_POST['id_admin']) ? $_POST['id_admin'] : "";
$mantenimiento = isset($_POST['mantenimiento']) ? $_POST['mantenimiento'] : "";
$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";

if (
  !$peticion
  && !$id_admin
  && !$mantenimiento
  && !$usuario
  && !$email
  && !$password
) {
  header('Content-Type: application/json');
  $jsonData = file_get_contents("php://input");
  $data = json_encode($jsonData, true);
  $peticion = $data['peticion'] ?? null;
  $id_admin = $data['id_admin'] ?? null;
  $mantenimiento = $data['mantenimiento'] ?? null;
  $usuario = $data['usuario'] ?? null;
  $email = $data['email'] ?? null;
  $password = $data['password'] ?? null;
}

// Procesamiento de los datos
switch ($peticion) {
  case "INSERT":
    $ctrl = new CtrlMtoAdministradores("INSERT", null, true);
    if (!$ctrl->validaAtributos(
      null,
      $usuario,
      $email,
      $password
    )) {
      echo json_encode(["result" => 0, "msg" => "ERROR: Datos inválidos"]);
    } else {
      $Email = new Email($email);
      if ($Email->existeEmail()) {
        echo json_encode(["result" => 0, "msg" => "El correo electrónico enviado ya está registrado en nuestra base de datos, elige otro"]);
      } else {
        if ($ctrl->insertaRegistro(
          $usuario,
          $email,
          password_hash($password, PASSWORD_DEFAULT)
        )) {
          echo json_encode(["result" => 1, "msg" => "Administrador registrado correctamente"]);
        } else echo json_encode(["result" => 0, "msg" => "ERROR: Problema de inserción en la Base de Datos"]);
      }
    }
    break;
  case "UPDATE":
    $ctrl = new CtrlMtoAdministradores("UPDATE", $id_admin, true);
    if ($password === "") $password = null;
    if (!$ctrl->validaAtributos(
      null,
      $usuario,
      $email,
      $password
    )) {
      echo json_encode(["result" => 0, "msg" => "ERROR: Datos inválidos"]);
    } else {
      $Email = new Email($email);
      $oldEmail = $ctrl->seleccionaRegistro($id_admin)[0]["email"];
      if ($Email->existeEmail() && $email !== $oldEmail) {
        echo json_encode(["result" => 0, "msg" => "El correo electrónico enviado ya existe en nuestra base de datos, elige otro"]);
      } else {
        if ($ctrl->modificaRegistro(
          $id_admin,
          $usuario,
          $email,
          $password === null ? null : password_hash($password, PASSWORD_DEFAULT)
        )) {
          if ($mantenimiento !== "1") {
            $_SESSION["datos"]["usuario"] = $usuario;
            $_SESSION["datos"]["email"] = $email;
            if (
              isset($_COOKIE['cookie_consent'])
              && $_COOKIE['cookie_consent'] === '1'
              && isset($_COOKIE["session_data"])
            ) {
              $cookieData = [
                "loggeado" => true,
                "usuario" => $_SESSION["usuario"],
                "datos" => $_SESSION["datos"]
              ];
              setcookie(
                "session_data",
                base64_encode(json_encode($cookieData)),
                time() + (86400 * 30), // 30 días
                "/",
                "",
                false,
                true // httponly
              );
            }
          }
          echo json_encode(
            [
              "result" => 1,
              "msg" => "Registro modificado correctamente",
              "nuevos_datos" => [
                "id_admin" => $id_admin,
                "usuario" => $usuario,
                "email" => $email,
              ]
            ]
          );
        } else {
          echo json_encode(["result" => 0, "msg" => "ERROR: Problema de modificación en la base de datos"]);
        }
      }
    }
    break;
  default:
    echo json_encode(["result" => 0, "msg" => "ERROR: Petición inválida"]);
    die();
}
