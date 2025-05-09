<?php
require_once __DIR__ . "/../../../model/Model.php";
class CtrlGestorClientes
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_clientes/gestor_clientes.php";
  const CSS = __DIR__ . "/../../../css/admin/gestor_clientes.css";
  const JS = __DIR__ . "/../../../js/admin/gestor_clientes.js";
  public $datos = null;

  function __construct()
  {
    $model = new Model();
    $this->datos = $model->seleccionaRegistros("clientes", ["*"]);
  }

  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"],
  ];
  public $title = "Gestor de clientes";

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
