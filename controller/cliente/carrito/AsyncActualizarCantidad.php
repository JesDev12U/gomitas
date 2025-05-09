<?php
ini_set('display_errors', E_ALL);
session_start();
require_once __DIR__ . "/CtrlCarrito.php";

// Recibe datos JSON desde el cliente
$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (isset($data["nuevaCantidad"]) && isset($data["id_producto"])) {
  $ctrlCarrito = new CtrlCarrito();
  if ($ctrlCarrito->actualizarCantidad((int)$data["nuevaCantidad"], (int)$data["id_producto"])) {
    $productosActualizados = $ctrlCarrito->obtenerProductosByIdProducto((int)$data["id_producto"]);
    $nuevoTotal = $ctrlCarrito->calcularTotal();
    echo json_encode(
      [
        "result" => 1,
        "msg" => "Producto añadido al carrito correctamente",
        "producto" => [
          "cantidad" => $productosActualizados[0]["cantidad"],
          "total" => $productosActualizados[0]["total"]
        ],
        "total" => $nuevoTotal
      ]
    );
  } else
    echo json_encode(["result" => 0, "msg" => "¡Ya no queda más stock para ese producto!"]);
}
