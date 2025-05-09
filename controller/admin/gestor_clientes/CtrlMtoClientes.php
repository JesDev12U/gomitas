<?php
require_once __DIR__ . "/../../../model/Model.php";

class CtrlMtoClientes
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_clientes/mto_clientes.php";
  const CSS = __DIR__ . "/../../../css/admin/mto_clientes.css";
  const JS = __DIR__ . "/../../../js/admin/mto_clientes.js";
  public $peticion;
  public $id_cliente;
  public $usuario;
  public $email;
  public $estado;
  public $title;
  public $opciones;

  public function __construct($peticion = null, $id_cliente = null, $usuario = "administrador")
  {
    if ($usuario === "administrador") {
      $this->title = "Mantenimiento de clientes";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"],
        ["nombre" => ICON_CERRAR_SESION, "href" => SITE_URL . RUTA_CERRAR_SESION, "id" => "cerrar-sesion"]
      ];
    } else {
      $this->title = "Configuración de la cuenta";
      $this->opciones = [
        ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"],
      ];
    }
    $this->peticion = $peticion;
    $this->id_cliente = $id_cliente;
    if ($id_cliente !== null) {
      $res = $this->seleccionaRegistro($id_cliente);
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
    $id_empleado = null,
    $usuario = null,
    $email = null,
    $password = null,
  ) {
    $res = true;
    if (!is_null($id_empleado)) {
      $id_empleado = (int)$id_empleado;
      $res = $res && is_integer(($id_empleado)) && $id_empleado > 0;
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

  public function seleccionaRegistro($id_cliente)
  {
    $model = new Model();
    return $model->seleccionaRegistros("clientes", ["*"], "id_cliente=$id_cliente");
  }
  public function insertaRegistro(
    $usuario,
    $email,
    $password,
  ) {
    $model = new Model();
    return $model->agregaRegistro(
      "clientes",
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
    $id_cliente,
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
        $password,
      ];
    }
    return $model->modificaRegistro("clientes", $campos, "id_cliente=$id_cliente", $variables);
  }

  public function deshabilitarRegistro($id_cliente)
  {
    $model = new Model();
    return $model->modificaRegistro("clientes", ["estado"], "id_cliente=$id_cliente", [0]);
  }

  public function habilitarRegistro($id_cliente)
  {
    $model = new Model();
    return $model->modificaRegistro("clientes", ["estado"], "id_cliente=$id_cliente", [1]);
  }
}
