<?php
require_once __DIR__ . "/../model/Model.php";
require_once __DIR__ . "/../config/Global.php";

class CtrlPaginaPrincipal
{
  const VISTA = __DIR__ . "/../view/principal.php";
  const CSS = __DIR__ . "/../css/principal.css";
  const JS = __DIR__ . "/../js/principal.js";
  public $opciones = [
    ["nombre" => ICON_CARRITO, "href" => SITE_URL . RUTA_CLIENTE . RUTA_CARRITO, "id" => "carrito"],
    ["nombre" => ICON_CUENTA, "href" => SITE_URL . RUTA_CLIENTE . RUTA_CUENTA, "id" => "cuenta"],
    ["nombre" => ICON_INICIAR_SESION, "href" => SITE_URL . RUTA_LOGIN, "id" => "login"]
  ];
  public $title = "Principal";
  public $datos = null;

  function __construct()
  {
    $model = new Model();
    $this->datos = $model->seleccionaRegistros(
      "productos",
      ["*"]
    );
  }

  public static function busquedaProducto($query)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "productos",
      ["*"],
      "nombre LIKE '%$query%'"
    );
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
}
