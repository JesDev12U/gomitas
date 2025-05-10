<?php
require_once __DIR__ . "/../config/Global.php";

class CtrlCrearCuenta
{
  const VISTA = __DIR__ . "/../view/crearCuenta.php";
  const CSS = __DIR__ . "/../css/crearCuenta.css";
  const JS = __DIR__ . "/../js/crearCuenta.js";
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"],
    ["nombre" => ICON_INICIAR_SESION, "href" => SITE_URL .  RUTA_LOGIN, "id" => "login"]
  ];
  public $title = "Crear cuenta";

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
