<?php
ini_set('display_errors', E_ALL);

require_once __DIR__ . "/../../../config/Global.php";
require_once __DIR__ . "/CtrlMtoProductos.php";
require_once __DIR__ . "/../../guardarFoto.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo json_encode(["result" => 0, "msg" => "Método no permitido"]);
  die();
}

// Recepción de los datos
$peticion = isset($_POST["peticion"]) ? $_POST["peticion"] : "";
$id_producto = isset($_POST["id_producto"]) ? $_POST["id_producto"] : "";
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
$categoria1 = isset($_POST["categoria1"]) ? $_POST["categoria1"] : "";
$categoria2 = isset($_POST["categoria2"]) ? $_POST["categoria2"] : "";
$categoria3 = isset($_POST["categoria3"]) ? $_POST["categoria3"] : "";
$precio = isset($_POST["precio"]) ? $_POST["precio"] : "";
$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
$cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : "";

if (
  !$peticion
  && !$id_producto
  && !$nombre
  && !$categoria1
  && !$categoria2
  && !$categoria3
  && !$precio
  && !$descripcion
  && !$cantidad
) {
  header('Content-Type: application/json');
  $jsonData = file_get_contents("php://input");
  $data = json_encode($jsonData, true);
  $peticion = $data['peticion'] ?? null;
  $id_producto = $data['id_producto'] ?? null;
  $nombre = $data['nombre'] ?? null;
  $categoria1 = $data['categoria1'] ?? null;
  $categoria2 = $data['categoria2'] ?? null;
  $categoria3 = $data['categoria3'] ?? null;
  $precio = $data['precio'] ?? null;
  $descripcion = $data['descripcion'] ?? null;
  $cantidad = $data['cantidad'] ?? null;
}

// Procesamiento de los datos
switch ($peticion) {
  case "INSERT":
    $ctrl = new CtrlMtoProductos("INSERT");
    if (!$ctrl->validaAtributos(
      null,
      $nombre,
      $categoria1,
      $categoria2,
      $categoria3,
      $precio,
      $descripcion,
      $cantidad
    )) {
      echo json_encode(["result" => 0, "msg" => "ERROR: Datos inválidos"]);
    } else {
      $foto_path = guardarFoto(null, null, "producto", "fotos_productos");
      if ($ctrl->insertaRegistro(
        $nombre,
        $categoria1,
        $categoria2,
        $categoria3,
        $precio,
        $descripcion,
        $cantidad,
        $foto_path
      )) {
        echo json_encode(["result" => 1, "msg" => "Registro insertado correctamente"]);
      } else {
        echo json_encode(["result" => 0, "msg" => "ERROR: Problema de inserción en BD"]);
      }
    }
    break;
  case "UPDATE":
    $ctrl = new CtrlMtoProductos("UPDATE", $id_producto);
    if (!$ctrl->validaAtributos(
      $id_producto,
      $nombre,
      $categoria1,
      $categoria2,
      $categoria3,
      $precio,
      $descripcion,
      $cantidad
    )) {
      echo json_encode(["result" => 0, "msg" => "ERROR: Datos inválidos"]);
    } else {
      $foto_path = guardarFoto("UPDATE", $id_producto, "producto", "fotos_productos");
      if ($ctrl->modificaRegistro(
        $id_producto,
        $nombre,
        $categoria1,
        $categoria2,
        $categoria3,
        $precio,
        $descripcion,
        $cantidad,
        $foto_path
      )) {
        // Verificar cantidad en los carritos de compra
        $ctrl->verificarStockCarrito();
        $ctrl->actualizarTotalCarrito($id_producto);
        echo json_encode(["result" => 1, "msg" => "Registro modificado correctamente"]);
      } else {
        echo json_encode(["result" => 0, "msg" => "ERROR: Problema de modificación en BD."]);
      }
    }
    break;
  default:
    echo json_encode(["result" => 0, "msg" => "ERROR: Petición inválida"]);
}
