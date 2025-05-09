
<?php
require_once __DIR__ . "/../../../model/Model.php";

class CtrlGestorProductos
{
  const VISTA = __DIR__ . "/../../../view/empleado/gestor_productos/gestor_productos.php";
  const CSS = __DIR__ . "/../../../css/empleado/gestor_productos.css";
  const JS = __DIR__ . "/../../../js/empleado/gestor_productos.js";

  // Opciones de menú y título
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"]
  ];
  public $title = "Productos";

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
