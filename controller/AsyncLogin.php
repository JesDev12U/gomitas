<?php
ini_set('display_errors', E_ALL);
require_once __DIR__ . "/CtrlLogin.php";
session_start();

$input = file_get_contents("php://input");
$data = json_decode($input, true);
$resultado = false;
$usuario = "";

// Validamos los datos
if (isset($data['email'], $data['password'])) {
  $ctrlLogin = new CtrlLogin();
  $peticion = $ctrlLogin->credencialesCorrectas($data['email'], $data['password']);
  if ($peticion !== null) {
    if (isset($_SESSION['codigo']) || isset($_SESSION['email'])) {
      session_unset();
    }
    $_SESSION["loggeado"] = true;
    $usuario = $_SESSION["usuario"] = $peticion;
    $_SESSION["datos"] = $ctrlLogin->obtenerDatosUsuario($peticion, $data['email']);
    $resultado = true;

    // Validar consentimiento y "recuérdame"
    if (
      isset($data['remember_me']) && $data['remember_me'] &&
      isset($_COOKIE['cookie_consent']) && $_COOKIE['cookie_consent'] === '1'
    ) {
      $cookieData = [
        "loggeado" => true,
        "usuario" => $peticion,
        "datos" => $_SESSION["datos"]
      ];
      // Serializa y codifica para evitar problemas de formato
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
  } else {
    $resultado = false;
    // Si login falla, elimina la cookie de sesión si existe
    setcookie("session_data", "", time() - 3600, "/", "", false, true);
  }
} else {
  $resultado = false;
}

echo json_encode(["resultado" => $resultado, "usuario" => $usuario]);
