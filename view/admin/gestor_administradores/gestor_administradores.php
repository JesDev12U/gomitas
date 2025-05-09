<!-- Area de contenido -->
<div class="container-fluid p-4">
  <a href="<?php echo SITE_URL ?>" class="btn btn-primary">
    <i class="fa-solid fa-arrow-left"></i> Regresar al menú principal
  </a>
  <h1>Gestor de administradores</h1>
  <br><br>
  <a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_MTO_ADMINISTRADORES ?>" class="btn btn-success">
    <i class="fas fa-plus"></i>
    Agregar
  </a>

  <table class="tblDatos" class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Correo electrónico</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->datos as $reg): ?>
        <tr>
          <td><?php echo $reg["id_admin"] ?></td>
          <td><?php echo $reg["usuario"] ?></td>
          <td><?php echo $reg["email"] ?></td>
          <td>
            <a class="btn btn-warning" href="<?php echo SITE_URL . RUTA_ADMINISTRADOR . RUTA_MTO_ADMINISTRADORES . $reg["id_admin"] ?>">
              <i class="fas fa-pen"></i>
              Modificar
            </a>
            <?php
            if ($reg["estado"]) {
              echo '<button class="btn btn-danger" id="btn-deshabilitar" data-url="' . SITE_URL .  '" data-usuario="administrador" data-id="' . $reg["id_admin"] . '">' .
                '<i class="fa-solid fa-ban"></i>
                  Deshabilitar
                </button>';
            } else {
              echo '<button class="btn btn-success" id="btn-habilitar" data-url="' . SITE_URL .  '" data-usuario="administrador" data-id="' . $reg["id_admin"] . '">' .
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