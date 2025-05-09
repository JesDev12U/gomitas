<!-- Area de contenido -->
<div class="container-fluid p-4">
  <a href="<?php echo SITE_URL ?>" class="btn btn-primary">
    <i class="fa-solid fa-arrow-left"></i>
  </a>
  <h1>Gestor de productos</h1>
  <br><br>
  <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_MTO_PRODUCTOS ?>" class="btn btn-success">
    <i class="fas fa-plus"></i>
    Agregar
  </a>
  <table class="tblDatos" class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Foto</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->datos as $reg): ?>
        <tr>
          <td><?= $reg["id_producto"] ?></td>
          <td><img src="<?= $reg["foto_path"] ?>" alt="Producto" class="img-users"></td>
          <td><?= $reg["nombre"] ?></td>
          <td class="monetario"><?= $reg["precio"] ?></td>
          <td><?= $reg["cantidad"] ?></td>
          <td>
            <a class="btn btn-warning" href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_MTO_PRODUCTOS . $reg["id_producto"] ?>">
              <i class="fas fa-pen"></i>
              Modificar
            </a>
            <?php
            if ($reg["estado"]) {
              echo '<button class="btn btn-danger" id="btn-deshabilitar" data-url="' . SITE_URL .  '" data-usuario="producto" data-id="' . $reg["id_producto"] . '">' .
                '<i class="fa-solid fa-ban"></i>
                Deshabilitar
              </button>';
            } else {
              echo '<button class="btn btn-success" id="btn-habilitar" data-url="' . SITE_URL .  '" data-usuario="producto" data-id="' . $reg["id_producto"] . '">' .
                '<i class="fa-solid fa-check"></i>
                Habilitar
              </button>';
            }
            ?>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<script src="<?php echo SITE_URL . "js/admin/des_hab_usuarios.js" ?>"></script>