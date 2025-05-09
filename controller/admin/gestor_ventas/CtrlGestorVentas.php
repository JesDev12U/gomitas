<?php
require_once __DIR__ . "/../../../model/Model.php";
require_once __DIR__ . "/../../../config/Global.php";

class CtrlGestorVentas
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_ventas/gestor_ventas.php";
  const CSS = __DIR__ . "/../../../css/admin/gestor_ventas.css";
  const JS = __DIR__ . "/../../../js/admin/gestor_ventas.js";
  public $model;
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"]
  ];
  public $title = "Ventas";
  public $ventas;
  public $productosVentas;

  function __construct()
  {
    $this->ventas = self::loadVentas();
    $this->productosVentas = self::loadProductosVentas();
  }

  public function renderContent()
  {
    include self::VISTA;
  }

  public function renderCSS()
  {
    include self::CSS;
  }

  public function renderJS()
  {
    include self::JS;
  }

  public function loadVentas()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "ventas",
      ["*"]
    );
  }

  public function loadProductosVentas()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "detalle_venta",
      [
        "detalle_venta.id_venta",
        "productos.foto_path",
        "productos.nombre",
        "detalle_venta.cantidad",
        "detalle_venta.importe"
      ],
      null,
      null,
      "INNER JOIN productos ON detalle_venta.id_producto = productos.id_producto"
    );
  }
}
