<?php
ini_set('display_errors', E_ALL);
session_start();
require_once __DIR__ . "/CtrlCarrito.php";

// Recibe datos JSON desde el cliente
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data["id_producto"])) {
  $ctrlCarrito = new CtrlCarrito();
  if ($ctrlCarrito->eliminarRegistro($data["id_producto"])) {
    $nuevoTotal = $ctrlCarrito->calcularTotal();
    echo json_encode(
      [
        "result" => 1,
        "msg" => "¡Producto eliminado del carrito correctamente!",
        "total" => $nuevoTotal
      ]
    );
  } else {
    echo json_encode(["result" => 0, "msg" => "Hubo un error al tratar de eliminar el producto del carrito"]);
  }
}
