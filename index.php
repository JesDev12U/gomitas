<?php
session_start();
ini_set('display_errors', E_ALL);
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/config/Global.php";
date_default_timezone_set(TIMEZONE);

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Restaurar sesión desde cookie si corresponde
if (
  !isset($_SESSION["loggeado"]) &&
  isset($_COOKIE['session_data']) &&
  isset($_COOKIE['cookie_consent']) && $_COOKIE['cookie_consent'] === '1'
) {
  $cookieData = json_decode(base64_decode($_COOKIE['session_data']), true);
  if (
    $cookieData &&
    isset($cookieData['loggeado']) && $cookieData['loggeado'] === true &&
    isset($cookieData['usuario']) && isset($cookieData['datos'])
  ) {
    $_SESSION["loggeado"] = true;
    $_SESSION["usuario"] = $cookieData["usuario"];
    $_SESSION["datos"] = $cookieData["datos"];
  }
}

// Capturar los parámetros de la URL
$page = null;
if (isset($_GET['page'])) {
  if ($_GET['page'] === "index.php") $page = 'principal';
  else $page = $_GET['page'];
} else $page = 'principal';
$action = isset($_GET['action']) ? $_GET['action'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Manejo de redireccionamiento de usuario
if (isset($_SESSION["loggeado"]) && $_SESSION["loggeado"]) {
  if ($_SESSION["usuario"] === "cliente") {
    // Solo permitir acceso a 'principal' y 'cliente'
    if ($page !== "principal" && $page !== "cliente") {
      $page = "principal";
      $action = null;
      $id = null;
    }
  } else {
    // Para empleados o administradores, solo permitir acceso a su dashboard principal
    if ($page !== $_SESSION["usuario"]) {
      $page = $_SESSION["usuario"];
      $action = null;
      $id = null;
    }
  }
} else {
  // Si no hay sesión, no permitir acceso a rutas protegidas
  if ($page === "administrador" || $page === "cliente") {
    $page = "principal";
    $action = null;
    $id = null;
  }
}

// Router
switch ($page) {
  case 'principal':
    require_once __DIR__ . "/controller/CtrlPaginaPrincipal.php";
    $ctrl = new CtrlPaginaPrincipal();
    break;
  case 'login':
    if ($action !== null || $id !== null) {
      require_once __DIR__ . "/controller/errors/CtrlError404.php";
      http_response_code(404);
      $ctrl = new CtrlError404();
    } else if (!(isset($_SESSION["loggeado"]) && $_SESSION["loggeado"] === true)) {
      require_once __DIR__ . "/controller/CtrlLogin.php";
      $ctrl = new CtrlLogin();
    }
    break;
  case 'administrador':
    include __DIR__ . "/routes/router_admin.php";
    break;
  default:
    // Página no encontrada
    require_once __DIR__ . "/controller/errors/CtrlError404.php";
    http_response_code(404);
    $ctrl = new CtrlError404();
}

include __DIR__ . "/view/master.php";
