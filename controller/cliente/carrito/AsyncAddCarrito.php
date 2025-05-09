<?php
ini_set('display_errors', E_ALL);
session_start();
require_once __DIR__ . "/CtrlCarrito.php";

// Recibe datos JSON desde el cliente
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!isset($_SESSION) || count($_SESSION) === 0) {
  echo json_encode(["redirect" => true]);
  die();
}

if (isset($data["id_producto"])) {
  $ctrlCarrito = new CtrlCarrito();
  if ($ctrlCarrito->insertarRegistro($data["id_producto"])) {
    echo json_encode(["result" => 1, "msg" => "¡Producto añadido al carrito correctamente!"]);
  } else {
    echo json_encode(["result" => 0, "msg" => "¡Ya no queda más stock para ese producto!"]);
  }
}
