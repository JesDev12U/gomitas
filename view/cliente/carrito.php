<div class="container py-5">
  <a href="<?php echo SITE_URL ?>" class="btn btn-primary" style="margin-bottom: 50px">
    <i class="fa-solid fa-arrow-left"></i>&nbsp;Regresar a la página principal
  </a>
  <h1 class="mb-4" id="title-carrito"><i class="fas fa-shopping-cart"></i> Carrito de Compras</h1>
  <div class="row">
    <?php if (count($this->productos) !== 0): ?>
      <!-- Columna izquierda: Tabla de productos -->
      <div class="col-12 col-lg-8 mb-4 mb-lg-0">
        <div class="table-responsive">
          <table class="tblDatos table align-middle">
            <thead class="table-light">
              <tr>
                <th scope="col">Foto</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Acción</th>
              </tr>
            </thead>
            <tbody>
              <?php $ordinal = 0 ?>
              <?php foreach ($this->productos as $producto): ?>
                <tr class="producto-carrito" data-id_producto="<?php echo $producto["id_producto"]; ?>">
                  <td>
                    <img src="<?php echo $producto["foto_path"] ?>" class="img-thumbnail img-producto" alt="Producto">
                  </td>
                  <td>
                    <strong class="nombre-producto"><?php echo $producto["nombre"] ?></strong>
                  </td>
                  <td class="precio-unitario monetario" data-precio="<?php echo $producto["precio"]; ?>">
                    <?php echo $producto["precio"] ?>
                  </td>
                  <td>
                    <div class="input-group input-group-sm flex-nowrap justify-content-center" style="width: auto;">
                      <button class="btn btn-outline-secondary px-2 btn-menos" data-url="<?php echo SITE_URL ?>" data-id_producto="<?php echo $producto["id_producto"] ?>" type="button"><i class="fas fa-minus"></i></button>
                      <input
                        type="number"
                        class="form-control text-center px-1 input-cantidad"
                        id="input-cantidad<?php echo $producto["id_producto"] ?>"
                        value="<?php echo $producto["cantidad"] ?>"
                        min="1"
                        max="<?php echo $producto["stock"] ?>"
                        style="width: 2.5em; font-size: 1rem;"
                        aria-label="Cantidad"
                        disabled>
                      <button class="btn btn-outline-secondary px-2 btn-mas" data-url="<?php echo SITE_URL ?>" data-id_producto="<?php echo $producto["id_producto"] ?>" type="button"><i class="fas fa-plus"></i></button>
                    </div>
                  </td>
                  <td id="subtotal<?php echo $producto["id_producto"] ?>" class="monetario"><?php echo $producto["total"] ?></td>
                  <td>
                    <button class="btn btn-danger btn-sm btn-eliminar" title="Eliminar" data-ordinal="<?php echo $ordinal++ ?>" data-url="<?php echo SITE_URL ?>" data-id_producto="<?php echo $producto["id_producto"] ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Columna derecha: Resumen de compra -->
      <div class="col-12 col-lg-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Resumen</h4>
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                Total
                <span id="total-compra" data-total="<?php echo $this->calcularTotal() ?>" class="monetario"><?php echo $this->calcularTotal() ?></span>
              </li>
            </ul>
            <button
              id="btn-comprar"
              class="btn btn-success"
              data-url="<?= SITE_URL ?>"
              style="width: 100%;"><i class="fa-solid fa-money-check-dollar"></i> Finalizar compra</button>
            <hr>
            <a href="<?php echo SITE_URL ?>" class="btn btn-outline-primary w-100"><i class="fas fa-arrow-left"></i> Seguir comprando</a>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-info">No hay productos para mostrar.</div>
    <?php endif ?>
  </div>
</div>