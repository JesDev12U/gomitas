<?php
require_once __DIR__ . "/../model/Model.php";
require_once __DIR__ . "/../config/Global.php";

class CtrlLogin
{
  const VISTA = __DIR__ . "/../view/login.php";
  const CSS = __DIR__ . "/../css/login.css";
  const JS = __DIR__ . "/../js/login.js";
  public $model;
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"]
  ];
  public $title = "Inicio de sesión";

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

  /**
   * Función que nos ayudará  a comprobar las credenciales del usuario
   * @param string $email Correo electrónico del usuario
   * @param string $password Contraseña en crudo (sin hash)
   * @return string|null Si las credenciales son correctas, devuelve un
   * string indicando el usuario, en caso contrario, regresa null 
   */
  public function credencialesCorrectas($email, $password)
  {
    $model = new Model();
    $tabla = "";
    $usuario = null;
    // Buscamos tabla por tabla hasta encontrar al usuario correspondiente
    $tabla = "clientes";
    $resultado = $model->seleccionaRegistros($tabla, ["email", "password", "estado"], "email='$email'");
    if (count($resultado) === 0) {
      $tabla = "administradores";
      $resultado = $model->seleccionaRegistros($tabla, ["email", "password", "estado"], "email='$email'");
    }

    if (count($resultado) !== 0) {
      // Si encontró un usuario, se verifica la contraseña
      // También se verifica si el usuario está habilitado
      if (password_verify($password, $resultado[0]['password']) && $resultado[0]['estado']) {
        if ($tabla === "clientes") $usuario = "cliente";
        else $usuario = "administrador";
      }
    }
    return $usuario;
  }

  /**
   * Función que nos ayudará a obtener los datos de un usuario para posteriormente guardar
   * dichos datos en la variable de sesión
   * @param string $usuario usuario al que se desea consultar -> cliente | empleado | administrador
   * @param string $email Correo electrónico del usuario a consultar
   * @return array $datos[0] contendrá todos los datos del usuario devueltos por Model 
   */
  public function obtenerDatosUsuario($usuario, $email)
  {
    $model = new Model();
    $tabla = "";
    if ($usuario === "cliente") $tabla = "clientes";
    else $tabla = "administradores";
    $datos = $model->seleccionaRegistros($tabla, ["*"], "email='$email'");
    return $datos[0];
  }
}
