<?php
require_once __DIR__ . "/../model/Model.php";
require_once __DIR__ . "/../config/Global.php";

class CtrlRecuperarPassword
{
  const VISTA = __DIR__ . "/../view/recuperar_password.php";
  const CSS = __DIR__ . "/../css/recuperar_password.css";
  const JS = __DIR__ . "/../js/recuperar_password.js";

  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"]
  ];

  public $title = "Recuperar contraseña";

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

  public function cambiarPassword($email, $newPassword)
  {
    $model = new Model();
    $tabla = "";
    // Buscamos tabla por tabla hasta encontrar al usuario correspondiente
    $tabla = "clientes";
    $resultado = $model->seleccionaRegistros($tabla, ["email"], "email='$email'");
    if (count($resultado) === 0) {
      $tabla = "administradores";
      $resultado = $model->seleccionaRegistros($tabla, ["email"], "email='$email'");
    }

    if (count($resultado) !== 0) {
      // Si encontró un usuario, se cambia la contraseña
      return $model->modificaRegistro($tabla, ['password'], "email='$email'", [password_hash($newPassword, PASSWORD_DEFAULT)]);
    }
    return false;
  }
}
