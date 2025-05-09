<a href="<?php echo SITE_URL . RUTA_ADMINISTRADOR  ?>" class="btn btn-primary" style="margin-bottom: 50px">
  <i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar a la página principal
</a>
<h1 style="margin: 32px 0 16px 0; text-align:center;">Ventas</h1>
<div class="ventas">
  <div class="title">Ventas</div>
  <?php if (count($this->ventas) !== 0): ?>
    <div class="table-responsive">
      <table class="modern-table">
        <thead>
          <th>ID Venta</th>
          <th>ID Cliente</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Foto</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Subtotal</th>
        </thead>
        <tbody>
          <?php foreach ($this->ventas as $venta): ?>
            <?php
            // Filtra los productos de esta venta
            $productos = array_filter($this->productosVentas, function ($producto) use ($venta) {
              return $producto["id_venta"] == $venta["id_venta"];
            });
            $rowspan = count($productos);
            $first = true;
            ?>
            <?php foreach ($productos as $producto): ?>
              <tr>
                <?php if ($first): ?>
                  <td rowspan="<?= $rowspan ?>"><?= $venta['id_venta'] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $venta['id_cliente'] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $venta['fecha'] ?></td>
                  <td rowspan="<?= $rowspan ?>"><?= $venta['hora'] ?></td>
                <?php endif ?>
                <td>
                  <img class="foto-producto" src="<?= htmlspecialchars($producto['foto_path']) ?>" alt="<?= htmlspecialchars($producto["nombre"]) ?>">
                </td>
                <td><?= htmlspecialchars($producto["nombre"]) ?></td>
                <td><?= htmlspecialchars($producto["cantidad"]) ?></td>
                <td class="monetario"><?= htmlspecialchars($producto["importe"]) ?></td>
              </tr>
              <?php $first = false; ?>
            <?php endforeach; ?>
            <tr class="venta-total-row">
              <td colspan="8" style="text-align:right;">Total venta</td>
              <td>
                <span class="monetario"><?= htmlspecialchars($venta["total"]) ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No hay productos para mostrar.</div>
  <?php endif ?>
</div>