<?php
ini_set('display_errors', E_ALL);
require_once __DIR__ . "/CtrlPaginaPrincipal.php";
require_once __DIR__ . "/renderProductosPrincipal.php";

// Recibe datos JSON desde el cliente
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data["query"])) {
  $html = renderProductosPrincipal(CtrlPaginaPrincipal::busquedaProducto($data["query"]));
  echo $html;
}
