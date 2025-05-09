<?php
require_once __DIR__ . "/../../../model/Model.php";
require_once __DIR__ . "/../../../config/Global.php";

class CtrlCarrito
{
  const VISTA = __DIR__ . "/../../../view/cliente/carrito.php";
  const CSS = __DIR__ . "/../../../css/cliente/carrito.css";
  const JS = __DIR__ . "/../../../js/cliente/carrito.js";
  public $model;
  public $id_cliente;
  public $productos = null;
  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL, "id" => "home"]
  ];
  public $title = "Carrito";

  function __construct()
  {
    $this->id_cliente = $_SESSION["datos"]["id_cliente"];
    $this->productos = $this->obtenerProductos();
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
  public function obtenerProductos()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "carrito",
      [
        "carrito.id_cliente",
        "carrito.id_producto",
        "productos.nombre",
        "productos.precio",
        "productos.estado",
        "productos.cantidad AS stock",
        "productos.foto_path",
        "carrito.cantidad",
        "carrito.total"
      ],
      "carrito.id_cliente = " . $this->id_cliente,
      null,
      "INNER JOIN productos ON carrito.id_producto = productos.id_producto"
    );
  }

  public static function obtenerRegistros($id_cliente)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "carrito",
      ["*"],
      "id_cliente=$id_cliente"
    );
  }

  public function obtenerProductosByIdProducto($id_producto)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "carrito",
      [
        "carrito.id_cliente",
        "carrito.id_producto",
        "productos.nombre",
        "productos.precio",
        "productos.estado",
        "productos.cantidad AS stock",
        "productos.foto_path",
        "carrito.cantidad",
        "carrito.total"
      ],
      "carrito.id_producto = $id_producto",
      null,
      "INNER JOIN productos ON carrito.id_producto = productos.id_producto"
    );
  }
  public function calcularTotal()
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "carrito",
      ["SUM(total) AS total"],
      "id_cliente=" . $this->id_cliente
    )[0]["total"];
  }

  public static function calcularTotalStatic($id_cliente)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "carrito",
      ["SUM(total) AS total"],
      "id_cliente=" . $id_cliente
    )[0]["total"];
  }

  public function insertarRegistro($id_producto)
  {
    // Verificar que el id_producto exista
    $model = new Model();
    $producto = $model->seleccionaRegistros(
      "productos",
      [
        "precio",
        "estado",
        "cantidad"
      ],
      "id_producto=$id_producto"
    );

    if (!is_array($producto) || count($producto) === 0) {
      return false;
    }

    // Ahora sí es seguro acceder a $producto[0]
    if ($producto[0]["estado"] === 0) return false;
    else if ($producto[0]["cantidad"] === 0) return false;

    // Verificar si el producto ya está en el carrito
    $carrito = $model->seleccionaRegistros(
      "carrito",
      [
        "cantidad",
        "total"
      ],
      "id_producto=$id_producto AND id_cliente = " . $this->id_cliente
    );

    // Verifica que no haya overflow de stock
    if (count($carrito) > 0 && $carrito[0]["cantidad"] == $producto[0]["cantidad"]) return false;

    if (count($carrito) !== 0) {
      // Ya existe en el carrito, entonces solo es un UPDATE a la cantidad de ese producto en carrito
      return $model->modificaRegistro(
        "carrito",
        [
          "cantidad",
          "total"
        ],
        "id_producto = $id_producto AND id_cliente = " . $this->id_cliente,
        [
          $carrito[0]["cantidad"] + 1,
          ($carrito[0]["cantidad"] + 1) * $producto[0]["precio"]
        ]
      );
    }
    // Con todo eso cumplido, se añade el producto al carrito
    return $model->agregaRegistroID(
      "carrito",
      [
        "id_cliente",
        "id_producto",
        "cantidad",
        "total"
      ],
      [
        $this->id_cliente,
        $id_producto,
        1,
        $producto[0]["precio"]
      ]
    ) == 0;
  }

  public function actualizarCantidad($nuevaCantidad, $id_producto)
  {
    $model = new Model();
    $producto = $model->seleccionaRegistros(
      "productos",
      ["precio", "cantidad"],
      "id_producto=$id_producto"
    )[0];
    if ($id_producto <= 0) return false;
    else if ($nuevaCantidad <= 0 || $nuevaCantidad > $producto["cantidad"])
      return false;
    return $model->modificaRegistro(
      "carrito",
      [
        "cantidad",
        "total"
      ],
      "id_producto=$id_producto",
      [
        $nuevaCantidad,
        $producto["precio"] * $nuevaCantidad
      ]
    );
  }

  public function eliminarRegistro($id_producto)
  {
    $model = new Model();
    return $model->eliminaRegistro(
      "carrito",
      "id_producto = $id_producto AND id_cliente = " . $this->id_cliente
    );
  }

  public static function limpiarCarrito($id_cliente)
  {
    $model = new Model();
    return $model->eliminaRegistro(
      "carrito",
      "id_cliente=" . $id_cliente,
    );
  }
}
