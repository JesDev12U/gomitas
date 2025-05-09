<?php
require_once __DIR__ . "/../../../model/Model.php";
class CtrlGestorAdministradores
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_administradores/gestor_administradores.php";
  const CSS = __DIR__ . "/../../../css/admin/gestor_administradores.css";
  const JS = __DIR__ . "/../../../js/admin/gestor_administradores.js";
  public $datos = null;

  function __construct()
  {
    $model = new Model();
    $this->datos = $model->seleccionaRegistros("administradores", ["*"], "id_admin <> " . $_SESSION["datos"]["id_admin"]);
  }

  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"]
  ];

  public $title = "Gestor de administradores";

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
