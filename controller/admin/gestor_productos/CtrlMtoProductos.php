
<?php
require_once __DIR__ . "/../../../model/Model.php";
require_once __DIR__ . "/../../../config/Global.php";

class CtrlMtoProductos
{
  const VISTA = __DIR__ . "/../../../view/admin/gestor_productos/mto_productos.php";
  const CSS = __DIR__ . "/../../../css/admin/mto_productos.css";
  const JS = __DIR__ . "/../../../js/admin/mto_productos.js";
  public $peticion;
  public $id_producto;
  public $nombre;
  public $precio;
  public $estado;
  public $cantidad;
  public $foto_path;

  public $title = "Mantenimiento de productos";

  public function __construct($peticion = null, $id_producto = null)
  {
    $this->peticion = $peticion;
    $this->id_producto = $id_producto;
    if ($id_producto !== null) {
      $res = $this->seleccionaRegistro($id_producto);
      if (count($res) !== 0) {
        $this->nombre = $res[0]["nombre"];
        $this->precio = $res[0]["precio"];
        $this->estado = $res[0]["estado"];
        $this->cantidad = $res[0]["cantidad"];
        $this->foto_path = $res[0]["foto_path"];
      }
    }
  }

  public $opciones = [
    ["nombre" => ICON_HOME, "href" => SITE_URL . RUTA_ADMINISTRADOR, "id" => "home"]
  ];

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

  public function seleccionaRegistro($id_producto)
  {
    $model = new Model();
    return $model->seleccionaRegistros(
      "productos",
      ["*"],
      "id_producto=$id_producto"
    ) ?? [];
  }

  public function seleccionaFoto($id_producto)
  {
    $model = new Model();
    return $model->seleccionaRegistros("productos", ['foto_path'], "id_producto=$id_producto");
  }

  public function validaAtributos(
    $id_producto = null,
    $nombre = null,
    $precio = null,
    $cantidad = null
  ) {
    $res = true;

    // Validación de id_producto
    if (!is_null($id_producto)) {
      $id_producto = (int)$id_producto;
      $res = $res && is_integer($id_producto) && $id_producto > 0;
    }

    // Validación de nombre
    if (!is_null($nombre)) {
      $res = $res && $nombre !== "" && strlen($nombre) <= 50;
    }

    // Validación de precio
    if (!is_null($precio)) {
      $res = $res && is_numeric($precio) && $precio >= 0;
    }

    // Validación de cantidad
    if (!is_null($cantidad)) {
      $res = $res && is_numeric($cantidad) && $cantidad >= 0;
    }

    return $res;
  }

  public function insertaRegistro(
    $nombre,
    $precio,
    $cantidad,
    $foto_path
  ) {
    $model = new Model();
    return $model->agregaRegistro(
      "productos",
      [
        "nombre",
        "precio",
        "estado",
        "cantidad",
        "foto_path"
      ],
      [
        $nombre,
        $precio,
        true,
        $cantidad,
        $foto_path
      ]
    );
  }

  public function modificaRegistro(
    $id_producto,
    $nombre,
    $precio,
    $cantidad,
    $foto_path
  ) {
    $model = new Model();
    // Comprobación de que la foto no se debe subir vacía
    $foto_path = $foto_path === "" ? $this->foto_path : $foto_path;
    return $model->modificaRegistro(
      "productos",
      [
        "nombre",
        "precio",
        "cantidad",
        "foto_path"
      ],
      "id_producto=$id_producto",
      [
        $nombre,
        $precio,
        $cantidad,
        $foto_path
      ]
    );
  }

  public function verificarStockCarrito()
  {
    $model = new Model();
    $productos = $model->seleccionaRegistros(
      "carrito",
      [
        "carrito.id_producto",
        "productos.cantidad AS stock",
        "productos.precio"
      ],
      "carrito.cantidad > productos.cantidad",
      null,
      "INNER JOIN productos ON carrito.id_producto = productos.id_producto"
    );
    if (count($productos) !== 0) {
      for ($i = 0; $i < count($productos); $i++) {
        $model->modificaRegistro(
          "carrito",
          [
            "cantidad",
            "total"
          ],
          "id_producto=" . $productos[$i]["id_producto"],
          [
            $productos[$i]["stock"],
            $productos[$i]["stock"] * $productos[$i]["precio"]
          ]
        );
      }
    }
  }

  public function actualizarTotalCarrito($id_producto)
  {
    $model = new Model();
    $precioProducto = $model->seleccionaRegistros(
      "productos",
      ["precio"],
      "id_producto=$id_producto",
    )[0]["precio"];
    $cantidadProductoCarrito = $model->seleccionaRegistros(
      "carrito",
      ["cantidad"],
      "id_producto=$id_producto"
    );
    if (isset($cantidadProductoCarrito[0]["cantidad"])) {
      $model->modificaRegistro(
        "carrito",
        ["total"],
        "id_producto=$id_producto",
        [$cantidadProductoCarrito[0]["cantidad"] * $precioProducto]
      );
    }
  }

  public function deshabilitarRegistro($id_producto)
  {
    $model = new Model();
    $model->eliminaRegistro(
      "carrito",
      "id_producto=$id_producto"
    );
    return $model->modificaRegistro(
      "productos",
      ["estado"],
      "id_producto=$id_producto",
      [0]
    );
  }

  public function habilitarRegistro($id_producto)
  {
    $model = new Model();
    return $model->modificaRegistro(
      "productos",
      ["estado"],
      "id_producto=$id_producto",
      [1]
    );
  }
}
