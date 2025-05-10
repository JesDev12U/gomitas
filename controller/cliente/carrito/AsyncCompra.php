<?php
/* TODO: Por el momento, se aprueba cualquier pago, próximamente se aplicará un método de pago REAL como
el de Mercado Pago. */
ini_set('display_errors', E_ALL);
require_once __DIR__ . "/../../../model/Model.php";
require_once __DIR__ . "/CtrlCarrito.php";
require_once __DIR__ . "/../../../classes/Email.php";
session_start();

if (!isset($_SESSION) || count($_SESSION) === 0) {
  echo json_encode(["result" => 0, "msg" => "No se puede solicitar la compra, no hay una sesión activa"]);
  die();
}

$id_cliente = $_SESSION["datos"]["id_cliente"];
// Creamos la venta
$model = new Model();
$totalCarrito = CtrlCarrito::calcularTotalStatic($id_cliente);
$id_venta = $model->agregaRegistroID(
  "ventas",
  [
    "id_cliente",
    "fecha",
    "hora",
    "total"
  ],
  [
    $id_cliente,
    date("Y-m-d"),
    date("H:i:s"),
    $totalCarrito
  ]
);
$email = $model->seleccionaRegistros("clientes", ["email"], "id_cliente=$id_cliente")[0]["email"];
// Consulta al carrito del cliente
$productos = CtrlCarrito::obtenerRegistros($id_cliente);
// INSERT a detalle_pedido
foreach ($productos as $producto) {
  $model->agregaRegistro(
    "detalle_venta",
    [
      "id_venta",
      "id_producto",
      "cantidad",
      "importe",
    ],
    [
      $id_venta,
      $producto['id_producto'],
      $producto["cantidad"],
      $producto["total"]
    ]
  );
}

CtrlCarrito::limpiarCarrito($id_cliente);
$Email = new Email($email);
$Email->notificarVenta($id_venta);

echo json_encode(["result" => 1, "msg" => "Compra realizada correctamente"]);
