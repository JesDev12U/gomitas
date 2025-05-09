<?php
require_once __DIR__ . "/../../../model/Model.php";

class CtrlMtoAdministradores
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_administradores/mto_administradores.php";
  const CSS = __DIR__ . "/../../../css/admin/mto_administradores.css";
  const JS = __DIR__ . "/../../../js/admin/mto_administradores.js";
  public $peticion;
  public $id_admin;
  public $usuario;
  public $email;
  public $estado;
  public $title;
  public $opciones;
  public $mantenimiento;

  public function __construct($peticion = null, $id_admin = null, $mantenimiento)
  {
    $this->mantenimiento = $mantenimiento;
    if ($mantenimiento) {
      $this->title = "Mantenimiento de administradores";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"]
      ];
    } else {
      $this->title = "Configuración de la cuenta";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"]
      ];
    }
    $this->peticion = $peticion;
    $this->id_admin = $id_admin;
    if ($id_admin !== null) {
      $res = $this->seleccionaRegistro($id_admin);
      if (count($res) !== 0) {
        $this->usuario = $res[0]["usuario"];
        $this->email = $res[0]["email"];
        $this->estado = $res[0]["estado"];
      }
    }
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

  public function validaAtributos(
    $id_admin = null,
    $usuario = null,
    $email = null,
    $password = null
  ) {
    $res = true;
    if (!is_null($id_admin)) {
      $id_admin = (int)$id_admin;
      $res = $res && is_integer($id_admin) && $id_admin > 0;
    }
    if (!is_null($usuario)) {
      $res = $res && $usuario !== "" && strlen($usuario) <= 50;
    }
    if (!is_null($email)) {
      $res = $res && preg_match('/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/', $email, $matches) && strlen($email) <= 80;
    }
    if (!is_null($password)) {
      $res = $res && $password !== "" && strlen($password) <= 16;
    }
    return $res;
  }

  public function seleccionaRegistro($id_admin)
  {
    $model = new Model();
    return $model->seleccionaRegistros("administradores", ["*"], "id_admin=$id_admin");
  }

  public function insertaRegistro(
    $usuario,
    $email,
    $password,
  ) {
    $model = new Model();
    return $model->agregaRegistro(
      "administradores",
      [
        "usuario",
        "email",
        "password",
        "estado",
      ],
      [
        $usuario,
        $email,
        $password,
        true,
      ]
    );
  }

  public function modificaRegistro(
    $id_admin,
    $usuario,
    $email,
    $password,
  ) {
    $model = new Model();
    $campos = [];
    $variables = [];
    if ($password === null) {
      $campos = [
        "usuario",
        "email",
      ];
      $variables = [
        $usuario,
        $email,
      ];
    } else {
      $campos = [
        "usuario",
        "email",
        "password",
      ];
      $variables = [
        $usuario,
        $email,
        $password
      ];
    }
    return $model->modificaRegistro("administradores", $campos, "id_admin=$id_admin", $variables);
  }

  public function deshabilitarRegistro($id_admin)
  {
    $model = new Model();
    return $model->modificaRegistro("administradores", ["estado"], "id_admin=$id_admin", [0]);
  }

  public function habilitarRegistro($id_admin)
  {
    $model = new Model();
    return $model->modificaRegistro("administradores", ['estado'], "id_admin=$id_admin", [1]);
  }
}
